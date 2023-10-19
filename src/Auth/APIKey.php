<?php

namespace Octopy\Cloudflare\Auth;

use Octopy\Cloudflare\Contracts\Auth;

class APIKey implements Auth
{
    /**
     * @param  string $email
     * @param  string $key
     */
    public function __construct(protected string $email, protected string $key)
    {
        //
    }

    /**
     * @return array
     */
    public function getHeaders() : array
    {
        return [
            'X-Auth-Key'   => $this->key,
            'X-Auth-Email' => $this->email,
        ];
    }
}