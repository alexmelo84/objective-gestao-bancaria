<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AccountController::class)->group(function () {
    Route::get('/conta', 'searchAccounts');
    Route::get('/conta/{id}', 'getAccountByID');
});