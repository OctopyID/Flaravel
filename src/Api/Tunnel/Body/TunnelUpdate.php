<?php

namespace Octopy\Flaravel\Api\Tunnel\Body;

use Octopy\Flaravel\Builder\Body;

class TunnelUpdate extends Body
{
    public const TYPE_WARP = 'warp';

    public const TYPE_CFDT = 'default';

    /**
     * @var array|string[]
     */
    protected array $rules = [
        'name'          => 'required|string',
        'tunnel_secret' => 'required|string',
    ];

    /**
     * A user-friendly name for the tunnel.
     *
     * @param  string $name
     * @return $this
     */
    public function name(string $name) : static
    {
        return $this->set('name', $name);
    }

    /**
     * Sets the password required to run a locally-managed tunnel. Must be at least 32 bytes and encoded as a base64 string.
     *
     * @param  string $secret
     * @return $this
     */
    public function tunnelSecret(string $secret) : static
    {
        return $this->set('tunnel_secret', $secret);
    }
}