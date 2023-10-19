<?php

namespace Octopy\Flaravel\Tests\Auth;

use Octopy\Flaravel\Auth\APIKey;
use Octopy\Flaravel\Tests\TestCase;

class APIKeyTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function getHeaders() : void
    {
        $auth = new APIKey('example@example.com', '0bee89b07a248e27c83fc3d5951213c1');
        $headers = $auth->getHeaders();

        $this->assertArrayHasKey('X-Auth-Key', $headers);
        $this->assertArrayHasKey('X-Auth-Email', $headers);

        $this->assertEquals('example@example.com', $headers['X-Auth-Email']);
        $this->assertEquals('0bee89b07a248e27c83fc3d5951213c1', $headers['X-Auth-Key']);

        $this->assertCount(2, $headers);
    }
}