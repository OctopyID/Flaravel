<?php

namespace Octopy\Flaravel\Contracts;

use Illuminate\Http\Client\Response;
use Octopy\Flaravel\Builder\Body;
use Octopy\Flaravel\Builder\Query;

interface Adapter
{
    /**
     * @param  Auth $auth
     */
    public function __construct(Auth $auth);

    /**
     * @param  Body $body
     * @return $this
     */
    public function body(Body $body) : static;

    /**
     * @param  Query|null $query
     * @return $this
     */
    public function query(Query $query = null) : static;

    /**
     * @param  string $url
     * @return Response
     */
    public function get(string $url) : Response;

    /**
     * @param  string $url
     * @return Response
     */
    public function post(string $url) : Response;

    /**
     * @param  string $url
     * @return Response
     */
    public function patch(string $url) : Response;

    /**
     * @param  string $url
     * @return Response
     */
    public function delete(string $url) : Response;
}