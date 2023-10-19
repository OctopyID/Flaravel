<?php

namespace Octopy\Cloudflare\Builder;

use Illuminate\Contracts\Support\Arrayable;

class Query implements Arrayable
{
    /**
     * @param  array $query
     */
    public function __construct(protected array $query = [])
    {
        //
    }

    /**
     * @param  string $key
     * @param  mixed  $value
     * @return $this
     */
    public function set(string $key, mixed $value) : static
    {
        $this->query[$key] = $value;

        return $this;
    }

    /**
     * @param  string $key
     * @return mixed
     */
    public function get(string $key) : mixed
    {
        return $this->query[$key];
    }

    /**
     * @param  string $key
     * @return bool
     */
    public function has(string $key) : bool
    {
        return array_key_exists($key, $this->query);
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return $this->query;
    }
}