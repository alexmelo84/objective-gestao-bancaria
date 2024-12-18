<?php

namespace App\Http\Controllers;

use App\Application\CreateAccount;
use App\Application\GetAccountById;
use App\Application\GetItemByField;
use App\Application\SearchAccount;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

/**
 * Controller for account related actions
 */
class AccountController extends Controller
{
    /**
     * Searches and returns accounts based on query string filters
     * 
     * @var Request $request
     * @return string
     */
    public function searchAccounts(Request $request): string
    {
        $searchAccount = new SearchAccount();
        $results = $searchAccount->search($request->input());

        return response()->json($results)->getContent();
    }

    /**
     * Get an account by ID
     * 
     * @return string
     */
    public function getAccountByID(): string
    {
        $objGetAccount = new GetAccountById('id', request()->route('id'));
        $objGetItem = new GetItemByField($objGetAccount);

        return response()->json($objGetItem->get())->getContent();
    }

    /**
     * Create an account
     * 
     * @var Request $request
     * @return string
     */
    public function createAccount(Request $request): string
    {
        // dd($request->saldo);
        $createAccount = new CreateAccount($request->all());

        return response()->json($createAccount->create(), 201)->getContent();
    }
}
