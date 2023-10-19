<?php

namespace Octopy\Cloudflare\Contracts;

use Illuminate\Http\Client\Response;
use Octopy\Cloudflare\Builder\Body;
use Octopy\Cloudflare\Builder\Query;

interface Adapter
{
    /**
     * @param  Auth $auth
     */
    public function __construct(Auth $auth);

    /**
     * @param  string     $path
     * @param  Query|null $query
     * @return Response
     */
    public function get(string $path, Query $query = null) : Response;

    /**
     * @param  string    $path
     * @param  Body|null $body
     * @return Response
     */
    public function post(string $path, Body $body = null) : Response;

    /**
     * @param  string    $string
     * @param  Body|null $body
     * @return Response
     */
    public function patch(string $string, Body $body = null) : Response;

    /**
     * @param  string $string
     * @return Response
     */
    public function delete(string $string) : Response;
}