<?php

namespace App\Interfaces;

use App\Models\Transaction;

interface TransactionATMFactoryInterface
{
    public function splitInMoneyBills(int $value): array;
    public function saveTransaction(int $accountID, string $transactionMethod, float $value): Transaction;
    public function validateTypeValue($value): bool;
    public function validateMinimunMoneyBill(int $value): bool;
    public function formatAmountByBill(array $bills): array;
}
