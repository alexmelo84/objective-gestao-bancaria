<?php

namespace App\Factory;

use App\Application\GetAccountById;
use App\Application\GetItemByField;
use App\Interfaces\TransactionATMFactoryInterface;
use App\Models\Account;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\DB;

class WithdrawAtmFactory implements TransactionATMFactoryInterface
{
    /**
     * @var array
     */
    protected array $availableBills = [20, 100, 10, 50];

    /**
     * @param $value
     * @return bool
     */
    public function validateTypeValue($value): bool
    {
        if (is_int($value) && $value > 0) {
            return true;
        }

        return false;
    }

    /**
     * @param int $value
     * @return bool
     */
    public function validateMinimunMoneyBill(int $value): bool
    {
        if ($value % min($this->availableBills) !== 0) {
            return false;
        }

        return true;
    }

    /**
     * @param int $value
     * @return array
     */
    public function splitInMoneyBills(int $value): array
    {
        $availableBills = $this->getAvailableBills();

        $bills = [];
        $valueLeft = $value;

        foreach ($availableBills as $bill) {
            $billsAmount = intdiv($valueLeft, $bill);
            if ($billsAmount === 0) {
                continue;
            }

            $bills[$bill] = $billsAmount;

            $valueLeft = $valueLeft % $bill;
            if ($valueLeft === 0) {
                break;
            }
        }
        
        return $bills;
    }

    /**
     * @return array
     */
    public function getAvailableBills(): array
    {
        arsort($this->availableBills);

        return $this->availableBills;
    }

    /**
     * @param array $bills
     * @return array
     */
    public function formatAmountByBill(array $bills): array
    {
        $formattedBills = [];
        foreach ($bills as $bill => $amount) {
            $formattedBills[] = "$amount nota(s) de R$ $bill,00";
        }

        return $formattedBills;
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
