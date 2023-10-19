<?php

namespace Octopy\Flaravel\Adapter;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Octopy\Flaravel\Builder\Body;
use Octopy\Flaravel\Builder\Query;
use Octopy\Flaravel\Contracts\Adapter;
use Octopy\Flaravel\Contracts\Auth;

class LaravelHttp implements Adapter
{
    protected PendingRequest $request;

    /**
     * @var string
     */
    protected string $baseURL = 'https://api.cloudflare.com/client/v4/';

    /**
     * @param  Auth $auth
     */
    public function __construct(protected Auth $auth)
    {
        $this->request = Http::baseUrl($this->baseURL)->acceptJson()->withHeaders($auth->getHeaders());
    }

    /**
     * @param  string     $path
     * @param  Query|null $query
     * @return Response
     */
    public function get(string $path, Query $query = null) : Response
    {
        if (! $query) {
            $query = new Query;
        }

        return $this->request->get($this->trim($path), $query->toArray());
    }

    /**
     * @param  string    $path
     * @param  Body|null $body
     * @return Response
     */
    public function post(string $path, Body $body = null) : Response
    {
        if (! $body) {
            $body = new Body;
        }

        return $this->request->post($this->trim($path), $body->toArray());
    }

    /**
     * @param  string    $string
     * @param  Body|null $body
     * @return Response
     */
    public function patch(string $string, Body $body = null) : Response
    {
        return $this->request->patch($this->trim($string), $body->toArray());
    }

    /**
     * @param  string $string
     * @return Response
     */
    public function delete(string $string) : Response
    {
        return $this->request->delete($this->trim($string));
    }

    /**
     * @param  string $path
     * @return string
     */
    private function trim(string $path) : string
    {
        return trim(preg_replace('/\/+/', '/', $path));
    }
}