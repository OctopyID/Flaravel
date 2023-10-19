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

    /**
     * @var string
     */
    public const CFDT = 'CFDT';

    /**
     * @var string
     */
    public const WARP = 'WARP';

    /**
     * @var string|null
     */
    private string|null $type = null;

    /**
     * @param  string|null $type
     * @return $this
     */
    public function type(#[ExpectedValues([Tunnel::CFDT, Tunnel::WARP])] string $type = null) : static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param  TunnelList|null $query
     * @return Response
     */
    public function lists(TunnelList $query = null) : Response
    {
        return match ($this->type) {
            Tunnel::CFDT => $this->adapter->query($query)->get('/accounts/' . $this->getAccount() . '/cfd_tunnel'),
            Tunnel::WARP => $this->adapter->query($query)->get('/accounts/' . $this->getAccount() . '/warp_connector'),
            default      => $this->adapter->query($query)->get('/accounts/' . $this->getAccount() . '/tunnels'),
        };
    }

    /**
     * @param  string $tunnel
     * @return Response
     */
    public function detail(string $tunnel) : Response
    {
        return match ($this->type) {
            Tunnel::CFDT => $this->adapter->get('/accounts/' . $this->getAccount() . '/cfd_tunnel/' . trim($tunnel)),
            Tunnel::WARP => $this->adapter->get('/accounts/' . $this->getAccount() . '/warp_connector/' . trim($tunnel)),
        };
    }

    /**
     * @param  TunnelCreate $body
     * @return Response
     */
    public function create(TunnelCreate $body) : Response
    {
        $body->set('type', $this->type);

        return match ($this->type) {
            Tunnel::CFDT => $this->adapter->body($body)->post('/accounts/' . $this->getAccount() . '/cfd_tunnel'),
            Tunnel::WARP => $this->adapter->body($body)->post('/accounts/' . $this->getAccount() . '/warp_connector'),
        };
    }

    /**
     * Updates an existing Cloudflare/Warp Connector Tunnel.
     *
     * @param  string       $tunnel
     * @param  TunnelUpdate $body
     * @return Response
     */
    public function update(string $tunnel, TunnelUpdate $body) : Response
    {
        return match ($this->type) {
            Tunnel::CFDT => $this->adapter->body($body)->patch('/accounts/' . $this->getAccount() . '/cfd_tunnel/' . trim($tunnel)),
            Tunnel::WARP => $this->adapter->body($body)->patch('/accounts/' . $this->getAccount() . '/warp_connector/' . trim($tunnel)),
        };
    }

    /**
     * Deletes a Cloudflare/Warp Tunnel from an account.
     *
     * @param  string $tunnel
     * @return Response
     */
    public function delete(string $tunnel) : Response
    {
        return match ($this->type) {
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