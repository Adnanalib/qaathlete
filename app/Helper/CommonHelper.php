<?php

use App\Enums\UserType;
use App\Models\AthleteDetail;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

function getUUID()
{
    $length = 5;
    $random = '';
    for ($i = 0; $i < $length; $i++) {
        $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
    }
    return $random;
}
function getRandomToken($length)
{
    $random = '';
    for ($i = 0; $i < $length; $i++) {
        $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
    }
    return $random;
}
function generateUUID()
{
    $uuid = getUUID();
    $length = User::where('uuid', $uuid)->count();
    if ($length == 0) {
        return $uuid;
    }
    return generateUUID();
}
function getUserProfileImage($user = null)
{
    if(!empty($user)){
        return !empty($user->profile_image) ? asset($user->profile_image) : asset('/assets/images/default.jpg');
    }
    return !empty(auth()->user()->profile_image) ? asset(auth()->user()->profile_image) : asset('/assets/images/default.jpg');
}
function getUserBackgroundImage($user = null)
{
    if(!empty($user)){
        return !empty($user->background_image) ? asset($user->background_image) : asset('/assets/images/default-background.jpg');
    }
    return !empty(auth()->user()->background_image) ? asset(auth()->user()->background_image) : asset('/assets/images/default-background.jpg');
}
function str_limit($string, $limit = 100, $end = '...')
{
    return Str::limit($string, $limit, $end);
}
function strUcFirst($string)
{
    $string = str_replace('_', ' ', $string);
    return ucfirst(strtolower($string));
}

function getCurrentUserHomeUrl()
{
    $user = User::find(Auth::user()->id);
    if ($user->type == UserType::ATHLETE) {
        $athlete_detail = AthleteDetail::where('user_id', Auth::user()->id)->latest()->first();
        if (User::isPaymentPaid($user)) {
            if (!empty($athlete_detail) && $athlete_detail->current_step > 4) {
                return url(RouteServiceProvider::ATHLETE_DASHBOARD);
            } else {
                return url(RouteServiceProvider::ATHLETE_ONBOARDING);
            }
        } else {
            if(auth()->user()->plan_id == app('freePlanId')){
                if(!empty($athlete_detail) && $athlete_detail->current_step > 4){
                    return url(RouteServiceProvider::ATHLETE_DASHBOARD);
                }else if(empty($athlete_detail) || (!empty($athlete_detail) && $athlete_detail->current_step < 5)){
                    return url(RouteServiceProvider::ATHLETE_ONBOARDING);
                }
            }
            return url(RouteServiceProvider::ATHLETE_PAYMENT);
        }
    } else if ($user->type == UserType::COACH) {
        if (User::isPaymentPaid($user)) {
            return url(RouteServiceProvider::COACH_DASHBOARD);
        } else {
            return url(RouteServiceProvider::COACH_PAYMENT);
        }
    }
}
function formatDateTime($value, $format)
{
    return Carbon::parse($value)->format($format);
}
function getCurrentUser(){
    if(Session::has('current_user') && config('qr.userObjectSessionEnabled') == 'true'){
        return Session::get('current_user');
    }
    $user = updateCurrentUser();
    return $user;
}

function updateCurrentUser(){
    if(auth()->check()){
        $user = User::find(auth()->user()->id);
        Session::put('current_user', $user);
        return $user;
    }
}

function dangerError($message, $title = "Server Error!", $extraCss = '')
{
    Session::flash('alert-class', 'alert-danger');
    Session::flash('alert-extra-class', 'setup-team-alert ' . $extraCss);
    Session::flash('alert-title', $title);
    Session::flash('message', $message);
}

function successMessage($message, $title = "Success!", $extraCss = '')
{
    Session::flash('alert-class', 'alert-success');
    Session::flash('alert-extra-class', 'setup-team-alert ' . $extraCss);
    Session::flash('alert-title', $title);
    Session::flash('message', $message);
}
function truncateText($text, $length) {
    return Str::limit($text, $length);
}
