<?php

namespace App\Http\Controllers;

use App\Application\CreateTransaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Create a transaction
     * 
     * @var Request $request
     * @return string
     */
    public function createTransaction(Request $request): string
    {
        $createTransaction = new CreateTransaction(
            $request->forma_pagamento,
            $request->numero_conta,
            $request->valor
        );

        return response()->json($createTransaction->create(), 201)->getContent();
    }
}
