<?php

namespace App\Application;

use App\Abstract\AbstractTransaction;
use Exception;

/**
 * Create a transaction
 */
class WithdrawAtm extends AbstractTransaction
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
     * @param int
     */
    protected int $withdrawValue;

    /**
     * @param string $transactionMethod
     * @param string $accountNumber
     * @param int $withdrawValue
     */
    public function __construct(
        string $transactionMethod,
        string $accountNumber,
        int $withdrawValue
    ) {
        $this->transactionMethod = $transactionMethod;
        $this->accountNumber = $accountNumber;
        $this->withdrawValue = $withdrawValue;
        $this->value = $withdrawValue;
    }

    /**
     * @return array
     */
    public function withdraw(): array
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

        try {
            if (!$transctionMethodFactory->validateTypeValue($this->withdrawValue)) {
                throw new Exception('Valor inválido', 400);
            }
        } catch (Exception $e) {
            throw $e;
        }

        try {
            if (!$transctionMethodFactory->validateMinimunMoneyBill($this->withdrawValue)) {
                throw new Exception('Valor inferior à menor cédula disponível', 400);
            }
        } catch (Exception $e) {
            throw $e;
        }

        $moneyBills = $transctionMethodFactory->splitInMoneyBills($this->withdrawValue);

        try {
            $transctionMethodFactory->saveTransaction(
                $getAccount['id'],
                $this->transactionMethod,
                $this->withdrawValue
            );
        } catch (Exception $e) {
            throw $e;
        }

        return $transctionMethodFactory->formatAmountByBill($moneyBills);
    }
}
