<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
         'http://localhost/anticipos/public/solicitudes_ff',
         'http://localhost/anticipos/public/cpp_anticipos',
         'http://localhost/anticipos/public/rendiciones_fondoupdate'
    ];
}
