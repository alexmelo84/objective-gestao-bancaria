<?php

namespace App\Factory;

use App\Abstract\AbstractTransactionFactory;
use App\Application\GetAccountById;
use App\Application\GetItemByField;
use App\Interfaces\TransactionFactoryInterface;
use App\Models\Account;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\DB;

class PixTransactionFactory extends AbstractTransactionFactory implements TransactionFactoryInterface
{
    public function calculateFee(float $baseValue): float
    {
        return $baseValue;
    }

    /**
     * @param int $accountID
     * @param string $transactionMethod
     * @param float $value
     * @return Transaction
     */
    public function saveTransaction(int $accountID, string $transactionMethod, float $value): Transaction
    {
        try {
            DB::beginTransaction();

            $transaction = new Transaction;
            $transaction->id_account = $accountID;
            $transaction->forma_pagamento = $transactionMethod;
            $transaction->valor = $value;
            $transaction->save();

            $getAccount = $this->getAccount($accountID);
            $newBalance = $getAccount['saldo'] - $value;

            $account = Account::find($accountID);
            $account->saldo = $newBalance;
            $account->save();
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        } finally {
            DB::commit();
        }

        return $transaction;
    }

    /**
     * @param int $accountID
     * @return array
     */
    protected function getAccount(int $accountID): array
    {
        $objGetAccount = new GetAccountById($accountID);
        $objGetItem = new GetItemByField($objGetAccount);
        return $objGetItem->get();
    }
}
