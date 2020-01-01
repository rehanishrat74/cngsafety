<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        '/do-login', 
        '/do-generate-pin',
        '/do-verify-pin',
        '/do-verify-code',
        '/do-update-particulars',
        '/do-update-cylinders',
        '/do-update-cng-kit',
        '/do-get-codes',
        '/do-upload-image',
        '/do-get-details'

    ];
}
