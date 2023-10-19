<?php

namespace Octopy\Flaravel\Api\Tunnel\Body;

use JetBrains\PhpStorm\ExpectedValues;
use Octopy\Flaravel\Builder\Body;

class TunnelCreate extends Body
{
    public const LOCAL = 'local';

    public const CLOUD = 'cloudflare';

    public const TYPE_WARP = 'warp';

    public const TYPE_CFDT = 'default';

    /**
     * @var array|string[]
     */
    protected array $rules = [
        'name'          => 'required',
        'config_src'    => 'required_if:type,' . self::TYPE_CFDT,
        'tunnel_secret' => 'required_if:type,' . self::TYPE_CFDT,
    ];

    /**
     * @var array
     */
    protected array $default = [
        'type' => 'default',
    ];

    /**
     * @param  string $type
     * @return $this
     */
    public function type(#[ExpectedValues([self::TYPE_CFDT, self::TYPE_WARP])] string $type) : static
    {
        return $this->set('type', $type);
    }

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
     * Indicates if this is a locally or remotely configured tunnel. If local, manage the tunnel using a YAML file on the origin machine.
     * If cloudflare, manage the tunnel on the Zero Trust dashboard or using the Cloudflare Tunnel configuration endpoint.
     *
     * @param  string $src
     * @return $this
     */
    public function configSrc(#[ExpectedValues([self::LOCAL, self::CLOUD])] string $src) : static
    {
        return $this->set('config_src', $src);
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

    /**
     * @return array
     */
    public function toArray() : array
    {
        $data = parent::toArray();

        if ($this->get('type') === self::TYPE_WARP) {
            unset($data['config_src']);
            unset($data['tunnel_secret']);
        }

        return $data;
    }
}