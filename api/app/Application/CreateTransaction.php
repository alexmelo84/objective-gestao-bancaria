<?php

namespace App\Application;

use App\Abstract\AbstractTransaction;
use Exception;

/**
 * Create a transaction
 */
class CreateTransaction extends AbstractTransaction
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
     * @param string $transactionMethod
     * @param string $accountNumber
     * @param float $value
     */
    public function __construct(
        string $transactionMethod,
        string $accountNumber,
        float $value
    ) {
        $this->transactionMethod = $transactionMethod;
        $this->accountNumber = $accountNumber;
        $this->value = $value;
    }

    /**
     * @return array
     */
    public function create(): array
    {
        try {
            if (!$this->validateTransactionMethod()) {
                throw new Exception('Método de transação inválido', 400);
            }
        } catch (Exception $e) {
            throw $e;
        }

        try {
            if (!$this->validateAccountExists()) {
                throw new Exception('Conta não existe', 404);
            }
        } catch (Exception $e) {
            throw $e;
        }

        try {
            if (!$this->validateAccountBalance()) {
                throw new Exception('Saldo insuficiente', 404);
            }
        } catch (Exception $e) {
            throw $e;
        }

        $getAccount = $this->getAccountByNumber($this->accountNumber);

        $transctionMethodFactory = $this->getTransctionMethodFactory();
        $finalValue = $transctionMethodFactory->calculateFee($this->value);

        try {
            $transctionMethodFactory->saveTransaction(
                $getAccount['id'],
                $this->transactionMethod,
                $finalValue
            );
        } catch (Exception $e) {
            throw $e;
        }

        $account = $this->getAccountByNumber($this->accountNumber);
        dd($account);
    }
}
