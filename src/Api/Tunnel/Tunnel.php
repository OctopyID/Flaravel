<?php

namespace Octopy\Cloudflare\Api\Tunnel;

use Illuminate\Http\Client\Response;
use JetBrains\PhpStorm\ExpectedValues;
use Octopy\Cloudflare\Api\Api;
use Octopy\Cloudflare\Api\Tunnel\Body\TunnelCreate;
use Octopy\Cloudflare\Api\Tunnel\Body\TunnelUpdate;
use Octopy\Cloudflare\Api\Tunnel\Query\TunnelList;
use Octopy\Cloudflare\Concerns\HasAccount;

class Tunnel extends Api
{
    use HasAccount;

    public const CFDT = 'CFDT';

    public const WARP = 'WARP';

    /**
     * @param  string|null     $type
     * @param  TunnelList|null $query
     * @return Response
     */
    public function lists(#[ExpectedValues([Tunnel::CFDT, Tunnel::WARP])] string $type = null, TunnelList $query = null) : \Illuminate\Http\Client\Response
    {
        return match ($type) {
            Tunnel::CFDT => $this->adapter->get('/accounts/' . $this->getAccount() . '/cfd_tunnel', $query),
            Tunnel::WARP => $this->adapter->get('/accounts/' . $this->getAccount() . '/warp_connector', $query),
            default      => $this->adapter->get('/accounts/' . $this->getAccount() . '/tunnels', $query),
        };
    }

    /**
     * @param  string $uuid
     * @param  string $type
     * @return Response
     */
    public function detail(string $uuid, #[ExpectedValues([Tunnel::CFDT, Tunnel::WARP])] string $type) : Response
    {
        return match ($type) {
            Tunnel::CFDT => $this->adapter->get('/accounts/' . $this->getAccount() . '/cfd_tunnel/' . trim($uuid)),
            Tunnel::WARP => $this->adapter->get('/accounts/' . $this->getAccount() . '/warp_connector/' . trim($uuid)),
        };
    }

    /**
     * @param  TunnelCreate $body
     * @return Response
     */
    public function create(TunnelCreate $body) : Response
    {
        return match ($body->get('type')) {
            Tunnel::CFDT => $this->adapter->post('/accounts/' . $this->getAccount() . '/cfd_tunnel', $body),
            Tunnel::WARP => $this->adapter->post('/accounts/' . $this->getAccount() . '/warp_connector', $body),
        };
    }

    /**
     * @param  TunnelUpdate $body
     * @return Response
     */
    public function update(TunnelUpdate $body) : Response
    {
        return match ($body->get('type')) {
            Tunnel::CFDT => $this->adapter->patch('/accounts/' . $this->getAccount() . '/cfd_tunnel', $body),
            Tunnel::WARP => $this->adapter->patch('/accounts/' . $this->getAccount() . '/warp_connector', $body),
        };
    }

    /**
     * @param  string $uuid
     * @param  string $type
     * @return Response
     */
    public function delete(string $uuid, #[ExpectedValues([Tunnel::CFDT, Tunnel::WARP])] string $type) : Response
    {
        return match ($type) {
            Tunnel::CFDT => $this->adapter->delete('/accounts/' . $this->getAccount() . '/cfd_tunnel/' . trim($uuid)),
            Tunnel::WARP => $this->adapter->delete('/accounts/' . $this->getAccount() . '/warp_connector/' . trim($uuid)),
        };
    }
}