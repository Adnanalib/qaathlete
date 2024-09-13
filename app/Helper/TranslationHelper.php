<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

/**
 * @param $message
 * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
 */
function translateMessage($message){
    App::setLocale(Session::get('current_locale','en'));
    return __($message);
}
