<?php

namespace App\Abstract;

use App\Application\GetAccountById;
use App\Application\GetAccountByNumber;
use App\Application\GetItemByField;
use App\Application\VerifyAccountNumberExists;
use App\Enum\TransactionEnum;
use App\Factory\CreditTransactionFactory;
use App\Factory\DebitTransactionFactory;
use App\Factory\PixTransactionFactory;
use App\Interfaces\TransactionFactoryInterface;

/**
 * Abstraction for transaction factory
 */
abstract class AbstractTransaction
{
    /**
     * @param string
     */
    protected string $transactionMethod;

    /**
     * @param string
     */
    protected string $accountNumber;

    /**
     * @param float
     */
    protected float $value;

    /**
     * @return bool
     */
    protected function validateTransactionMethod(): bool
    {
        if (!in_array($this->transactionMethod, TransactionEnum::toArray())) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function validateAccountExists(): bool
    {
        $accountExists = new VerifyAccountNumberExists();
        if ($accountExists->verify('numero_conta', $this->accountNumber)) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function validateAccountBalance(): bool
    {
        $objGetAccount = new GetAccountByNumber($this->accountNumber);
        $objGetItem = new GetItemByField($objGetAccount);
        $account = $objGetItem->get();

        if ($account['saldo'] >= $this->value) {
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    protected function getAccountByNumber(): array
    {
        $objGetAccount = new GetAccountByNumber($this->accountNumber);
        $objGetItem = new GetItemByField($objGetAccount);
        return $objGetItem->get();
    }

    /**
     * @return TransactionFactoryInterface
     */
    protected function getTransctionMethodFactory(): TransactionFactoryInterface
    {
        switch ($this->transactionMethod) {
            case TransactionEnum::C->name:
                return new CreditTransactionFactory;
                break;
            case TransactionEnum::D->name:
                return new DebitTransactionFactory;
                break;
            case TransactionEnum::P->name:
                return new PixTransactionFactory;
                break;
        }
    }
}