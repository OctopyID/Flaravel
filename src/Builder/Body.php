<?php

namespace Octopy\Flaravel\Builder;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class Body implements Arrayable
{
    /**
     * @var array
     */
    protected array $rules = [];

    /**
     * @var array
     */
    protected array $default = [];

    /**
     * @param  array $body
     */
    public function __construct(private array $body = [])
    {
        $this->body = array_merge($this->default, $this->body);
    }

    /**
     * @param  string $key
     * @param  mixed  $value
     * @return $this
     */
    public function set(string $key, mixed $value) : static
    {
        Arr::set($this->body, $key, $value);

        return $this;
    }

    /**
     * @param  string     $key
     * @param  mixed|null $default
     * @return mixed|null
     */
    public function get(string $key, mixed $default = null) : mixed
    {
        return Arr::get($this->body, $key, $default);
    }

    /**
     * @param  array $rules
     * @return array
     */
    public function validate(array $rules = []) : array
    {
        return Validator::make($this->body, $this->rules = array_merge($this->rules, $rules))->validate();
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        if (empty($this->rules)) {
            return $this->body;
        }

        return $this->validate();
    }
}