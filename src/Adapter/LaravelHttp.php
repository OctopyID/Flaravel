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
    /**
     * @var Body|null
     */
    protected Body|null $body = null;

    /**
     * @var Query|null
     */
    protected Query|null $query = null;

    /**
     * @var PendingRequest
     */
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
     * @param  Body $body
     * @return $this
     */
    public function body(Body $body) : static
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @param  Query|null $query
     * @return $this
     */
    public function query(Query $query = null) : static
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @param  string $url
     * @return Response
     */
    public function get(string $url) : Response
    {
        return $this->request->get($this->trim($url), $this->query?->toArray());
    }

    /**
     * @param  string $url
     * @return Response
     */
    public function post(string $url) : Response
    {
        return $this->request->post($this->trim($url), $this->body?->toArray());
    }

    /**
     * @param  string $url
     * @return Response
     */
    public function patch(string $url) : Response
    {
        return $this->request->patch($this->trim($url), $this->body?->toArray());
    }

    /**
     * @param  string $url
     * @return Response
     */
    public function delete(string $url) : Response
    {
        return $this->request->delete($this->trim($url));
    }

    /**
     * @param  string $url
     * @return string
     */
    private function trim(string $url) : string
    {
        return trim(preg_replace('/\/+/', '/', $url));
    }
}