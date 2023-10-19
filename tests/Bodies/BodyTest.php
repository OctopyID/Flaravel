<?php

namespace Octopy\Cloudflare\Tests\Bodies;

use Illuminate\Validation\ValidationException;
use Octopy\Cloudflare\Tests\TestCase;

class Body extends \Octopy\Cloudflare\Builder\Body
{
    //
}

class BodyTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function validate() : void
    {
        $this->expectException(ValidationException::class);

        $body = new Body([
            'foo' => 'bar',
            'baz' => 'qux',
        ]);

        $body->validate([
            'bar' => 'required',
        ]);
    }
}