<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AccountController::class)->group(function () {
    Route::get('/conta', 'searchAccounts');
    Route::get('/conta/{id}', 'getAccountByID');
    Route::post('/conta', 'createAccount');
});

Route::controller(TransactionController::class)->group(function () {
    Route::post('/transacao', 'createTransaction');
});
