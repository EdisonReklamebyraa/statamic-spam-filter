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

    'url' => env('EDGE_GUARD_URL'),

    /*
    |--------------------------------------------------------------------------
    | Edge Filter API Key
    |--------------------------------------------------------------------------
    |
    | The shared secret configured on the Edge Filter service.
    | This is sent as the X-API-Key header on every request.
    |
    */

    'api_key' => env('EDGE_GUARD_API_KEY'),

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

    /*
    |--------------------------------------------------------------------------
    | Shadow Mode
    |--------------------------------------------------------------------------
    |
    | When enabled, spam is detected and logged but submissions are never
    | blocked. Use this to verify the filter is working correctly before
    | enabling it for real. Defaults to true for safety.
    |
    */

    'shadow_mode' => env('EDGE_FILTER_SHADOW_MODE', true),

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    |
    | When enabled, all verdicts are written to the application log so you
    | can monitor what the filter is detecting.
    |
    */

    'log' => env('EDGE_FILTER_LOG', true),

];
