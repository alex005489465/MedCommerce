<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Contracts\Auth\Middleware\AuthenticatesRequests;
use App\Exceptions\CustomAuthenticationException;

class CustomAuthenticate extends Middleware implements AuthenticatesRequests
{
    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws App\Exceptions\CustomAuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        throw new CustomAuthenticationException(
            'Unauthenticated.', 
            $guards,
        );
    }
        
}
