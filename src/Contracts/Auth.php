<?php

namespace Octopy\Flaravel\Contracts;

interface Auth
{
    /**
     * @return array
     */
    public function getHeaders() : array;
}