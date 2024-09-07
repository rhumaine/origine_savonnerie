<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indique les URIs qui devraient être exclues de la vérification CSRF.
     *
     * @var array
     */
    protected $except = [
        'panier/ajouter/*',
    ];
}
