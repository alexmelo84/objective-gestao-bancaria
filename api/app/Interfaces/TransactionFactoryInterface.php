<?php

namespace App\Interfaces;

use App\Models\Transaction;

interface TransactionFactoryInterface
{
    public function calculateFee(float $baseValue): float;
    public function saveTransaction(int $accountID, string $transactionMethod, float $value): Transaction;
}
