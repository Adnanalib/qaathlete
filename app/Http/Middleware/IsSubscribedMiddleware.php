<?php

namespace App\Http\Middleware;

use App\Enums\UserType;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;

class IsSubscribedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if(empty($user)){
            return redirect()->intended('login');
        }
        $isPaid = User::isPaymentPaid($user);
        if($user->type == UserType::ATHLETE && (auth()->user()->plan_id != app('freePlanId') && !$isPaid)){
            return redirect()->intended(RouteServiceProvider::ATHLETE_PAYMENT);
        }else if($user->type == UserType::COACH && !$isPaid){
            return redirect()->intended(RouteServiceProvider::COACH_PAYMENT);
        }
        return $next($request);
    }
}
