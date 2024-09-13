<?php

namespace App\Http\Controllers;

use App\Enums\HttpResponse;
use App\Enums\QrPreference;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\TeamMember;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartController extends Controller
{
    private $product = null;
    private $variant = null;
    private $cart = null;
    private $order = null;
    private $cartItem = null;
    private $teamMember = null;
    protected $user = '';
    public function __construct()
    {
        $this->product = new Product();
        $this->variant = new Variant();
        $this->cart = new Cart();
        $this->teamMember = new TeamMember();
        $this->order = new Order();
        $this->cartItem = new CartItem();
    }
    public function detail(Request $request)
    {
        $cartItems = $this->cart->getAllItems();
        $cart_count = $this->cart->getCartCount();
        $team = $request->user()->team;
        $shipping = 1.50;
        $tax = 1.50;
        $discount = 1.50;
        $cartSummary = $this->cart->getSummary();
        return view('cart.detail', compact('cartItems', 'cart_count', 'cartSummary', 'team'));
    }
    public function checkout(Request $request)
    {
        $cart_count = $this->cart->getCartCount();
        $cart = $this->cart->getBySession();
        $order_count = !empty($cart) ? $this->order->getCartCount($cart->sessionId) : 0;
        if ($cart_count == 0) {
            return User::authenticateAndRedirect();
        }
        if ($order_count > 0) {
            return User::authenticateAndRedirect();
        }
        $cartItems = $this->cart->getAllItems();
        $shipping = 1.50;
        $tax = 1.50;
        $discount = 1.50;
        $cartSummary = $this->cart->getSummary();
        return view('cart.checkout', compact('cartItems', 'cart_count', 'cartSummary'));
    }

    public function removeItem(Request $request)
    {
        try {
            DB::beginTransaction();
            $cartItem = $this->cart->getItemByProductId($request->productId);
            if (!empty($cartItem)) {
                $cartItem->delete();
            }
            DB::commit();
            return statusResponseSuccess([], __('Success! Item removed from cart.'), HttpResponse::SUCCESS);
        } catch (\Exception $ex) {
            DB::rollback();
            return statusResponseError(null, $ex->getMessage(), HttpResponse::SERVER);
        }
    }

    public function addToCart(Request $request)
    {
        $errors = [];
        try {
            DB::beginTransaction();
            $user = $request->user();
            $quantity = $request->quantity;
            if($user->type == UserType::COACH){
                $quantity = $this->teamMember->getTeamMemberQuantity($user->team->id);
            }
            if($user->type == UserType::ATHLETE){
                if (!in_array($request->variant, $this->variant->pluck('name')->toArray())) {
                    $errors['variant'] = __('Invalid Variant! Please select right variant.');
                }
                if (!in_array($request->preference, QrPreference::getValues())) {
                    $errors['qr-preference'] = __('Invalid Preference! Please select right preference.');
                }
                if ($quantity <= 0) {
                    $errors['quantity'] = __('Invalid Quantity! Please select a quantity.');
                }
            }
            if($user->type == UserType::COACH){
                if (!in_array($request->preference, QrPreference::getValues())) {
                    $errors['qr-preference'] = __('Invalid Preference! Please select right preference.');
                }
                if($quantity == 0){
                    return statusResponseError(null, "You didn't set your team yet. Please setup team First", HttpResponse::SERVER);
                }
            }
            if (count($errors) > 0) {
                return statusResponseError(null, '', HttpResponse::VALIDATION, $errors);
            }
            $product = $this->product->findBy('uuid', $request->uuid);
            if (empty($product)) {
                return statusResponseError(null, __('Error! No product found against this uuid'), HttpResponse::NOT_FOUND);
            }
            $request->merge([
                'user_id' => $user->id,
                'team_id' => $user->team->id ?? null,
                'type' => $user->type,
                'product_id' => $product->id,
                'category_id' => $product->category_id,
                'sku' => $product->uuid,
                'discount' => $quantity * $product->discount,
                'quantity' => $quantity,
                'price' => $quantity * $product->getPrice(),
            ]);
            $cart = $this->cart->getBySession();
            if (empty($cart)) {
                $cart = new Cart();
                if (config('app.cart_session') == 'true') {
                    $sessionId = Str::random(30);
                    Session::put('cartSessionId-'. $user->id, $sessionId);
                    $request->merge([
                        'sessionId' => $sessionId,
                    ]);
                }
            }
            $cart = $this->cart->saveOrUpdate($cart, $request);
            $request->merge([
                'cart_id' => $cart->id,
            ]);
            $cartItem = $this->cart->getItemByProductId($product->id);
            if (empty($cartItem)) {
                $cartItem = new CartItem();
            }
            $this->cartItem->saveOrUpdate($cartItem, $request);
            DB::commit();
            return statusResponseSuccess([], __('Success! Product added to car successfully.'), HttpResponse::SUCCESS);
        } catch (\Exception $ex) {
            DB::rollback();
            return statusResponseError(null, $ex->getMessage(), HttpResponse::SERVER);
        }
    }
}
