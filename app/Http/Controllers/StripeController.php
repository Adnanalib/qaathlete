<?php

namespace App\Http\Controllers;

use App\Enums\HttpResponse;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class StripeController extends Controller
{
    protected $publish_key = '';
    protected $user = '';
    protected $team = '';

    public function __construct(Request $request)
    {
        $this->publish_key = config('strip.key');
        parent::__construct();
    }
    public function token()
    {
        return response()->json([
            'token' => $this->publish_key
        ], HttpResponse::SUCCESS);
    }
    public function createSubscription(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->user = $request->user();
            if ($this->user && !$this->user->stripe_id) {
                $this->user->createOrGetStripeCustomer();
            }
            if(getCurrentUser()->isCoach()){
                throw new \Exception('Unauthorized Access.');
            }
            if (empty($this->user->nextPlan)) {
                throw new \Exception('Please select a plan first.');
            }
            if (getCurrentUser()->isAthlete() && $this->user->nextPlan->id == app('freePlanId')) {
                throw new \Exception("It is free plan. You don't need to proceed with payment.");
            }
            if (empty($request->paymentMethodId)) {
                throw new \Exception('Unable to process payment at the moment. Please try again later.');
            }
            if (getCurrentUser()->isSubscribedToFree() || empty(getCurrentUser()->athlete)) {
                logDebug('createSubscription', [], 'strip');
                $subscription = $this->user->newSubscription($this->productName, $this->user->nextPlan->priceId)
                                            ->trialDays($this->user->nextPlan->trial)
                                            ->create($request->paymentMethodId);
            } else {
                logDebug('swapSubscription', [], 'strip');
                $subscription = $this->user->subscription($this->productName)
                                            ->swap($this->user->nextPlan->priceId)
                                            ->update([
                                                'payment_method' => $request->paymentMethodId,
                                            ]);
            }
            getCurrentUser()->setPlanId($this->user->nextPlan->priceId);
            getCurrentUser()->setNextPlanIdNull();
            DB::commit();
            return response()->json($subscription, HttpResponse::SUCCESS);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => [
                    'message' => $e->getMessage()
                ]
            ], HttpResponse::VALIDATION);
        }
    }
    public function createTeamSubscription(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->user = $request->user();
            $teamSubscriptionPlanId = config('strip.team_subscription_plan_id');
            if ($this->user && !$this->user->stripe_id) {
                $this->user->createOrGetStripeCustomer();
            }
            if(getCurrentUser()->isAthlete()){
                throw new \Exception('Unauthorized Access.');
            }
            if (empty($request->paymentMethodId)) {
                throw new \Exception('Unable to process payment at the moment. Please try again later.');
            }
            if (empty($teamSubscriptionPlanId)) {
                throw new \Exception("System didn't find any subscription plan for team subscription. Please contact system administrator.");
            }
            $addMorePlayerSize = !empty($this->user->upgrade_team_size) && User::isPaymentPaid($this->user) ? (int)$this->user->upgrade_team_size : 0;
            if (!empty($addMorePlayerSize)) {
                $subscription = $this->user->subscription($this->productName)->incrementQuantity($addMorePlayerSize);
                $this->user->upgrade_team_size = 0;
                $this->user->save();
                $this->team = $request->user()->team;
                if (!empty($this->team)) {
                    $this->team->saveOrUpdate($this->team, $request->replace([
                        'total' => $this->team->total + $addMorePlayerSize
                    ]));
                    $this->team->save();
                    for ($index = 0; $index < $addMorePlayerSize; $index++) {
                        $uuid = generateUUID();
                        $teamQR = createTeamQRCode($uuid);
                        $teamMember = new TeamMember();
                        $teamMember->saveOrUpdate(new $teamMember, $request->replace([
                            'uuid' => $uuid,
                            'team_id' => $this->team->id,
                            'qr_image_url' => $teamQR['qr_image_url'],
                            'qr_url' => $teamQR['qr_url'],
                            'qr_id' => $teamQR['qr_id'],
                            'qr_data' => $teamQR['qr_data'],
                        ]));
                    }
                }
            } else {
                $subscription = $this->user->newSubscription($this->productName, $teamSubscriptionPlanId)
                    ->quantity($this->user->team->total)
                    ->create($request->paymentMethodId);
            }
            logDebug("Coach Subscription. User: $this->user, Subscription: $subscription", [], 'strip');
            DB::commit();
            return response()->json($subscription, HttpResponse::SUCCESS);
        } catch (\Exception $e) {
            DB::rollback();
            logError("Coach Subscription Failed. Reason: " . $e->getMessage(), [], 'strip');
            return response()->json([
                'error' => [
                    'message' => $e->getMessage()
                ]
            ], HttpResponse::VALIDATION);
        }
    }
    public function cancelSubscription()
    {
        try {
            if (getCurrentUser()->isAthlete() && getCurrentUser()->canCancel()) {
                getCurrentUser()->cancelSubscription();
                getCurrentUser()->setPlanId(app('freePlanName'));
                successMessage('Package Cancelled successfully.', 'Success!', 'ml-f-0 mx-100');
                return redirect()->back();
            }
            if (!getCurrentUser()->canCancel()) {
                dangerError('Unable to cancel free subscription', 'Operation failed!', 'ml-f-0 mx-100');
            } else if (getCurrentUser()->isCoach()) {
                dangerError('You are not allowed to cancel your subscription.', 'Operation failed!', 'mx-100 ml-f-0');
            }
        } catch (\Throwable $th) {
            dangerError($th->getMessage(), 'Operation failed!', 'mx-100 ml-f-0');
            return redirect()->back();
        }
        return redirect()->back();
    }
}
