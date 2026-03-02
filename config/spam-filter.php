<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Edge Filter API URL
    |--------------------------------------------------------------------------
    |
    | The base URL of your deployed Edge Filter service.
    | Example: https://spam.yourdomain.com
    |
    */

    'url' => env('EDGE_FILTER_URL'),

    /*
    |--------------------------------------------------------------------------
    | Edge Filter API Key
    |--------------------------------------------------------------------------
    |
    | The shared secret configured on the Edge Filter service.
    | This is sent as the X-API-Key header on every request.
    |
    */

    'api_key' => env('EDGE_FILTER_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | Seconds to wait for the Edge Filter API to respond. If the service
    | is unreachable or times out, the submission is allowed through.
    |
    */

    'timeout' => env('EDGE_FILTER_TIMEOUT', 3),

];
