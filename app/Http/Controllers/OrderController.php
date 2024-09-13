<?php

namespace App\Http\Controllers;

use App\Enums\CartStatus;
use App\Enums\HttpResponse;
use App\Enums\TransactionStatus;
use App\Enums\UserType;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{

    private $cart = null;
    private $order = null;
    private $orderItem = null;
    private $transaction = null;
    protected $user = '';
    public function __construct()
    {
        $this->cart = new Cart();
        $this->transaction = new Transaction();
        $this->order = new Order();
        $this->orderItem = new OrderItem();
    }
    public function orderSuccess(Request $request){
        $key = 'cartSessionId-'. auth()->user()->id;
        if(!Session::has($key)){
            return User::authenticateAndRedirect();
        }
        if(config('app.forget_order') == 'true'){
            Session::forget($key);
        }
        $order = $this->order->getBySessionId(Session::get($key));
        return view('cart.checkout-success', compact('order'));
    }
    public function placeOrder(Request $request)
    {
        try {
            DB::beginTransaction();
            $paymentSummary = $this->cart->getSummary();
            $this->user = $request->user();
            if ($this->user && !$this->user->stripe_id) {
                $this->user->createOrGetStripeCustomer();
            }
            if (!$this->cart->hasCart()) {
                throw new \Exception('Your cart is empty. Please add some product in your card to process payment.');
            }
            if (empty($request->paymentMethodId)) {
                throw new \Exception('Unable to process payment at the moment. Please try again later.');
            }
            $payment = $this->user->charge(round($paymentSummary->total * 100), $request->paymentMethodId);

            Log::debug('payment' . json_encode($payment));

            if (!empty($payment)) {
                //Place an order against payment now
                $cart = $this->cart->getWithItems();

                $request->merge([
                    'user_id' => $request->user()->id,
                    'team_id' => $request->user()->team->id ?? null,
                    'type' => $request->user()->type,
                    'token' => !empty($order) ? $order->token : getRandomToken(10),
                    'sessionId' => $cart->sessionId,
                    'billing_address' => $request->additionalData['address'] ?? '',
                    'card_holder_name' => $request->additionalData['name'] ?? '',
                    'shipping' => $paymentSummary->shipping,
                    'tax' => $paymentSummary->tax,
                    'discount' => $paymentSummary->discount,
                    'sub_total' => $paymentSummary->item_total_price,
                    'total' => $paymentSummary->total_exclude_discount,
                    'grand_total' => $paymentSummary->total,
                    'code' => $payment->id ?? null,
                    'response' => json_encode($payment),
                ]);

                $order = $this->order->getBySessionId($cart->sessionId);

                if (empty($order)) {
                    $order = new Order();
                }

                $order = $this->order->saveOrUpdate($order, $request);

                foreach ($cart->items as $key => $cartItem) {
                    $this->orderItem->store($cart, $cartItem, $order);
                }

                $transaction = $this->transaction->getByOrderId($order->id);

                if (empty($transaction)) {
                    $transaction = new Transaction();
                }

                $request->merge([
                    'order_id' => $order->id,
                    'status' => !empty($payment) ? TransactionStatus::PAID : TransactionStatus::UN_PAID,
                ]);

                $transaction = $this->transaction->saveOrUpdate($transaction, $request);

                $cart->status = CartStatus::COMPLETE;

                $cart->save();

                if(auth()->user()->type == UserType::ATHLETE){
                    $order->storeSheet();
                }else if(auth()->user()->type == UserType::COACH){
                    $order->storeCoachSheet();
                }
            }
            DB::commit();
            return statusResponseSuccess([], __('Success! Order Placed successfully.'), HttpResponse::SUCCESS);
        } catch (\Exception $e) {
            DB::rollback();
            return statusResponseError(null, $e->getMessage(), HttpResponse::SERVER);
        }
    }
}
