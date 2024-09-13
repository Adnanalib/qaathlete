<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetContentLengthHeader
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Check if the response has content
        if ($response->content()) {
            // Set the Content-Length header to the length of the response content
            $response->header('Content-Length', strlen($response->content()));
        }

        return $response;
    }
}
