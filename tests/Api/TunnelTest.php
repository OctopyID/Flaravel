<?php

namespace Octopy\Cloudflare\Tests\Api;

use Octopy\Cloudflare\Api\Tunnel\Tunnel;
use Octopy\Cloudflare\Tests\TestCase;

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

        $response = $tunnel->account('123456789')->lists(Tunnel::CFDT);

        $this->assertSame('blog', $response->json('result.0.name'));

        $response = $tunnel->account('123456789')->lists(Tunnel::WARP);

        $this->assertSame('blog', $response->json('result.0.name'));
    }
}