<?php

namespace App\Http\Controllers;

use App\Models\Subscription as ModelsSubscription;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Laravel\Cashier\Http\Controllers\WebhookController;
use Stripe\Stripe;
use Stripe\Subscription;

class StripeWebhookController extends WebhookController
{
    /**
     * Handle the customer.subscription.deleted event.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleCustomerSubscriptionDeleted(array $payload)
    {
        logDebug('payload' . json_encode($payload), [], 'strip');
        $subscriptionId = $payload['data']['object']['id'];
        logDebug('handleCustomerSubscriptionDeleted' . $subscriptionId, [], 'strip');
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $subscription = Subscription::retrieve($subscriptionId);
        $subscriptionObject = ModelsSubscription::where('stripe_id', $subscriptionId)->latest()->first();
        logDebug('subscriptionObject' . json_encode($subscriptionObject), [], 'strip');
        logDebug('subscription' . json_encode($subscription), [], 'strip');
        if ($subscription && $subscriptionObject) {
            $user = User::find($subscriptionObject->user_id);
            if($user && $user->isAthlete() && $user->canCancel()){
                $user->setPlanId(app('freePlanName'));
            }
        }
        // Return a response to Stripe to confirm that the webhook was received and processed
        return $this->successMethod();
    }
}
