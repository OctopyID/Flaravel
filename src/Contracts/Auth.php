<?php

namespace Octopy\Cloudflare\Contracts;

interface Auth
{
    /**
     * @return array
     */
    public function getHeaders() : array;
}