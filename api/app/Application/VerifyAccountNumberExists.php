<?php

namespace App\Application;

use App\Models\Account;
use Exception;

/**
 * Verify if an account number already exists
 */
class VerifyAccountNumberExists
{
    /**
     * @param string $field
     * @param string $value
     * @return bool
     */
    public function verify(string $field, string $value): bool
    {
        $account = Account::where($field, $value)->get()->first();
        if (empty($account)) {
            return false;
        }

        return true;
    }
}
