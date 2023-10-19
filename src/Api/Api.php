<?php

namespace Octopy\Flaravel\Api;

use Octopy\Flaravel\Adapter\LaravelHttp;
use Octopy\Flaravel\Contracts\Adapter;
use Octopy\Flaravel\Contracts\Auth;

abstract class Api
{
    /**
     * @param  Adapter $adapter
     */
    public function __construct(protected Adapter $adapter)
    {
        //
    }

    /**
     * @param  Auth $auth
     * @return static
     */
    public static function make(Auth $auth) : static
    {
        return new static(new LaravelHttp($auth));
    }
}