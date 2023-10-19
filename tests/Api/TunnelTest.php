<?php

namespace Octopy\Flaravel\Tests\Api;

use Octopy\Flaravel\Api\Tunnel\Tunnel;
use Octopy\Flaravel\Tests\TestCase;

class TunnelTest extends TestCase
{
    /**
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function getTunnels() : void
    {
        $this->fake([
            '/accounts/123456789/tunnels'        => $this->getJsonFixtureResponse('getListCloudflareTunnel.json'),
            '/accounts/123456789/cfd_tunnel'     => $this->getJsonFixtureResponse('getListCloudflareTunnel.json'),
            '/accounts/123456789/warp_connector' => $this->getJsonFixtureResponse('getListCloudflareTunnel.json'),
        ]);

        $tunnel = Tunnel::make($this->getApiKey());

        $response = $tunnel->account('123456789')->lists();

        $this->assertSame('blog', $response->json('result.0.name'));

        $response = $tunnel->account('123456789')->type(Tunnel::CFDT)->lists();

        $this->assertSame('blog', $response->json('result.0.name'));

        $response = $tunnel->account('123456789')->type(Tunnel::WARP)->lists();

        $this->assertSame('blog', $response->json('result.0.name'));
    }
}