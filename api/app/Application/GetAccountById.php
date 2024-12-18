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
    private string $field;

    /**
     * int $value
     */
    private int $value;

    /**
     * @var string $field
     * @var int $value
     */
    public function __construct(string $field, int $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return Account::where($this->field, $this->value)->get()->first()->toArray();
    }
}
