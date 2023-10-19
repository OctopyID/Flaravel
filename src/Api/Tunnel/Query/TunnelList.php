<?php

namespace Octopy\Cloudflare\Api\Tunnel\Query;

use Illuminate\Support\Carbon;
use Octopy\Cloudflare\Builder\Query;
use Octopy\Cloudflare\Concerns\HasPagination;

class TunnelList extends Query
{
    use HasPagination;

    /**
     * @param  string $uuid
     * @return TunnelList
     */
    public function uuid(string $uuid) : TunnelList
    {
        return $this->set('uuid', $uuid);
    }

    /**
     * @param  Carbon|string $date
     * @return TunnelList
     */
    public function wasActiveAt(Carbon|string $date) : TunnelList
    {
        return $this->set('was_active_at', $date);
    }

    /**
     * @param  Carbon|string $date
     * @return TunnelList
     */
    public function wasInactiveAt(Carbon|string $date) : TunnelList
    {
        return $this->set('was_inactive_at', $date);
    }

    /**
     * @param  string $prefix
     * @return TunnelList
     */
    public function excludePrefix(string $prefix) : TunnelList
    {
        return $this->set('exclude_prefix', $prefix);
    }

    /**
     * @param  string $prefix
     * @return TunnelList
     */
    public function includePrefix(string $prefix) : TunnelList
    {
        return $this->set('include_prefix', $prefix);
    }

    /**
     * @param  Carbon|string $date
     * @return TunnelList
     */
    public function existedAt(Carbon|string $date) : TunnelList
    {
        return $this->set('existed_at', $date);
    }

    /**
     * @param  bool $deleted
     * @return TunnelList
     */
    public function isDeleted(bool $deleted = true) : TunnelList
    {
        return $this->set('is_deleted', $deleted);
    }
}