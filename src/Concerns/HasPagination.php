<?php

namespace Octopy\Flaravel\Concerns;

trait HasPagination
{
    /**
     * @param  int $page
     * @return $this
     */
    public function page(int $page) : static
    {
        return $this->set('page', $page);
    }

    /**
     * @param  int $perPage
     * @return $this
     */
    public function perPage(int $perPage) : static
    {
        return $this->set('per_page', $perPage);
    }
}