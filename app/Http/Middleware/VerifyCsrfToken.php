<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        'payway/ipn', // អនុញ្ញាត ABA POST មកដោយគ្មាន CSRF token
    ];
}
