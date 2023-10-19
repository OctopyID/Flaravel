<?php

namespace Octopy\Cloudflare\Api;

use Octopy\Cloudflare\Adapter\LaravelHttp;
use Octopy\Cloudflare\Contracts\Adapter;
use Octopy\Cloudflare\Contracts\Auth;

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