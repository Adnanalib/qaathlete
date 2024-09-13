<?php

namespace App\Http\Middleware;

use App\Enums\UserType;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;

class CoachMiddleware
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
        if (empty($user)) {
            return redirect()->intended('login');
        }
        if ($user->type == UserType::ATHLETE) {
            return redirect()->intended(RouteServiceProvider::ATHLETE_DASHBOARD);
        }
        return $next($request);
    }
}
