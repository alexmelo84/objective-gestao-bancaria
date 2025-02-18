<?php

namespace App\Application;

use App\Interfaces\GetItemInterface;
use App\Models\Account;

/**
 * Get an account by its ID
 */
class GetAccountById implements GetItemInterface
{
    /**
     * string $field
     */
    private string $field = 'id';

    /**
     * int $value
     */
    private int $value;

    /**
     * @var string $field
     * @var int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        $account = Account::where($this->field, $this->value)->get()->first();
        if (empty($account)) {
            abort(404);
        }

        return Account::where($this->field, $this->value)->get()->first()->toArray();
    }
}
