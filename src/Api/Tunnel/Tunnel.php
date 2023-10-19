<?php

namespace Octopy\Flaravel\Api\Tunnel;

use Illuminate\Http\Client\Response;
use JetBrains\PhpStorm\ExpectedValues;
use Octopy\Flaravel\Api\Api;
use Octopy\Flaravel\Api\Tunnel\Body\TunnelCreate;
use Octopy\Flaravel\Api\Tunnel\Body\TunnelUpdate;
use Octopy\Flaravel\Api\Tunnel\Query\TunnelList;
use Octopy\Flaravel\Concerns\HasAccount;

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
    public function lists(TunnelList $query = null, #[ExpectedValues([Tunnel::CFDT, Tunnel::WARP])] string $type = null) : \Illuminate\Http\Client\Response
    {
        return match ($type) {
            Tunnel::CFDT => $this->adapter->get('/accounts/' . $this->getAccount() . '/cfd_tunnel', $query),
            Tunnel::WARP => $this->adapter->get('/accounts/' . $this->getAccount() . '/warp_connector', $query),
            default      => $this->adapter->get('/accounts/' . $this->getAccount() . '/tunnels', $query),
        };
    }

    /**
     * @param  string $tunnel
     * @param  string $type
     * @return Response
     */
    public function detail(string $tunnel, #[ExpectedValues([Tunnel::CFDT, Tunnel::WARP])] string $type) : Response
    {
        return match ($type) {
            Tunnel::CFDT => $this->adapter->get('/accounts/' . $this->getAccount() . '/cfd_tunnel/' . trim($tunnel)),
            Tunnel::WARP => $this->adapter->get('/accounts/' . $this->getAccount() . '/warp_connector/' . trim($tunnel)),
        };
    }

    /**
     * @param  string       $type
     * @param  TunnelCreate $body
     * @return Response
     */
    public function create(TunnelCreate $body, #[ExpectedValues([Tunnel::CFDT, Tunnel::WARP])] string $type) : Response
    {
        $body->set('type', $type);

        return match ($type) {
            Tunnel::CFDT => $this->adapter->post('/accounts/' . $this->getAccount() . '/cfd_tunnel', $body),
            Tunnel::WARP => $this->adapter->post('/accounts/' . $this->getAccount() . '/warp_connector', $body),
        };
    }

    /**
     * Updates an existing Cloudflare/Warp Connector Tunnel.
     *
     * @param  string       $type
     * @param  TunnelUpdate $body
     * @return Response
     */
    public function update(TunnelUpdate $body, #[ExpectedValues([Tunnel::CFDT, Tunnel::WARP])] string $type) : Response
    {
        return match ($type) {
            Tunnel::CFDT => $this->adapter->patch('/accounts/' . $this->getAccount() . '/cfd_tunnel', $body),
            Tunnel::WARP => $this->adapter->patch('/accounts/' . $this->getAccount() . '/warp_connector', $body),
        };
    }

    /**
     * Deletes a Cloudflare/Warp Tunnel from an account.
     *
     * @param  string $tunnel
     * @param  string $type
     * @return Response
     */
    public function delete(string $tunnel, #[ExpectedValues([Tunnel::CFDT, Tunnel::WARP])] string $type) : Response
    {
        return match ($type) {
            Tunnel::CFDT => $this->adapter->delete('/accounts/' . $this->getAccount() . '/cfd_tunnel/' . trim($tunnel)),
            Tunnel::WARP => $this->adapter->delete('/accounts/' . $this->getAccount() . '/warp_connector/' . trim($tunnel)),
        };
    }

    /**
     * Removes a connection (aka Cloudflare Tunnel Connector) from a Cloudflare Tunnel independently of its current state.
     * If no connector id (client_id) is provided all connectors will be removed.
     *
     * @param  string      $tunnel
     * @param  string|null $client
     * @return Response
     */
    public function cleanup(string $tunnel, string $client = null) : Response
    {
        $url = '/accounts/' . $this->getAccount() . '/cfd_tunnel/' . trim($tunnel) . '/connections';
        if ($client) {
            $url .= '?client_id=' . trim($client);
        }

        return $this->adapter->delete($url);
    }
}