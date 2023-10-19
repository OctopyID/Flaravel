<?php

namespace Octopy\Flaravel\Tests\Bodies;

use Octopy\Flaravel\Api\Tunnel\Body\TunnelCreate;
use Octopy\Flaravel\Tests\TestCase;

class TunnelBodyTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function validateCloudflareTunnel() : void
    {
        $body = new TunnelCreate;

        $body->type(TunnelCreate::TYPE_CFDT)->name('blog')->configSrc(TunnelCreate::LOCAL)->tunnelSecret('secret');

        $this->assertArrayHasKey('name', $body->toArray());
        $this->assertArrayHasKey('config_src', $body->toArray());
        $this->assertArrayHasKey('tunnel_secret', $body->toArray());
    }

    /**
     * @test
     * @return void
     */
    public function validateWarpTunnel() : void
    {
        $body = new TunnelCreate;
        $body->type(TunnelCreate::TYPE_WARP)->name('blog')->configSrc(TunnelCreate::LOCAL)->tunnelSecret('secret');

        $this->assertArrayHasKey('name', $body->toArray());

        $this->assertArrayNotHasKey('config_src', $body->toArray());
        $this->assertArrayNotHasKey('tunnel_secret', $body->toArray());
    }
}