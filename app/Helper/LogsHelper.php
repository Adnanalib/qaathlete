<?php

use Illuminate\Support\Facades\Log;

function logDebug($logMessage = '', $array = [], $channel = 'stack'){
    try {
        Log::channel($channel)->debug($logMessage, $array);
    } catch (\Exception $e) {
        Log::error('Error while processing log message. Exception: ' . $e);
    }
}

function logError($logMessage = '', $array = [], $channel = 'single'){
    try {
        Log::channel($channel)->error($logMessage, $array);
    } catch (\Exception $e) {
        Log::error('Error while processing log message. Exception: ' . $e);
    }
}
