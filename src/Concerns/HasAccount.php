<?php

namespace Octopy\Flaravel\Concerns;

trait HasAccount
{
    protected string $account;

    /**
     * @param  string $account
     * @return $this
     */
    public function account(string $account) : static
    {
        $this->account = trim($account);

        return $this;
    }

    /**
     * @return string
     */
    private function getAccount() : string
    {
        return $this->account;
    }
}