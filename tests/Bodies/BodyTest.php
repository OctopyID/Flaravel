<?php

namespace Octopy\Flaravel\Tests\Bodies;

use Illuminate\Validation\ValidationException;
use Octopy\Flaravel\Tests\TestCase;

class Body extends \Octopy\Flaravel\Builder\Body
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