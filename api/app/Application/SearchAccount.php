<?php

namespace App\Application;

use App\Abstract\AbstractSearch;
use App\Interfaces\SearchInterface;
use App\Models\Account;

/**
 * Handler for any account search
 */
class SearchAccount extends AbstractSearch implements SearchInterface
{
    /**
     * @param string $tableName
     */
    public string $tableName = 'accounts';

    /**
     * @var array $queryParameters
     * @return array
     */
    public function search(array $queryParameters): array
    {
        $this->setFields(['numero_conta', 'saldo']);
        $this->setParameters($queryParameters);

        $account = $this->executeSearch();

        return $account;
    }

    /**
     * @return array
     */
    public function executeSearch(): array
    {
        return Account::select($this->fields)->where($this->parameters)->get()->toArray();
    }
}
