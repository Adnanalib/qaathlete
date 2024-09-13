<?php

namespace App\Http\Middleware;

use App\Enums\UserType;
use App\Models\AthleteDetail;
use Closure;
use Illuminate\Http\Request;

class CheckOnboardingMiddleware
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
        $athlete = (new AthleteDetail())->findBy('user_id', $user->id);
        if($user->type == UserType::ATHLETE && !empty($athlete) && $athlete->current_step < 5){
            return redirect()->intended(getCurrentUserHomeUrl());
        }
        return $next($request);
    }
}
