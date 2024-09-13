<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;

class PaymentController extends Controller
{
    public function athletePayment(Request $request)
    {
        getCurrentUser()->setNextPlanId($request->plan_id);
        if(!empty($request->plan_id)){
            return redirect()->route('athletes.payment');
        }
        if(!User::isPaymentPaid($request->user()) || !empty(getCurrentUser()->nextPlan)){
            return view('athletes.payment.index');
        }
        return User::authenticateAndRedirect();
    }
    public function coachPayment(Request $request)
    {
        $addMorePlayerSize = 0;
        if(!empty($request->isUpgrade) && !empty($request->player_size)){
            $addMorePlayerSize = (int) $request->player_size;
            $user = $request->user();
            $user->upgrade_team_size = $addMorePlayerSize;
            $user->save();
        }
        $team = $request->user()->team;
        $totalPrice = $request->user()->getCoachSubscriptionPrice();
        if(!User::isPaymentPaid($request->user()) || $addMorePlayerSize > 0){
            return view('coach.payment.index', compact('team', 'addMorePlayerSize'));
        }
        return User::authenticateAndRedirect();
    }

}
