<?php

namespace App\Application;

use App\Abstract\AbstractCreateItem;
use App\Interfaces\CreateItemInterface;
use App\Models\Account;
use Exception;

/**
 * Create an account
 */
class CreateAccount extends AbstractCreateItem implements CreateItemInterface
{
    /**
     * @var array $input
     */
    private array $input;

    /**
     * @param array $requiredFields
     */
    public array $requiredFields = ['numero_conta', 'saldo'];

    /**
     * @var array $input
     */
    public function __construct(array $input)
    {
        $this->input = $input;
    }

    /**
     * @return array
     */
    public function create(): array
    {
        try {
            if (!$this->validateFields($this->input)) {
                throw new Exception('Campo obrigatório não enviado.', 400);
            }
        } catch (Exception $e) {
            throw $e;
        }

        try {
            $accountExists = new VerifyAccountNumberExists();
            if ($accountExists->verify('numero_conta', $this->input['numero_conta'])) {
                throw new Exception('Número da conta já existe.', 400);
            }
        } catch (Exception $e) {
            throw $e;
        }

        $account = new Account;
        $account->numero_conta = $this->input['numero_conta'];
        $account->saldo = $this->input['saldo'];

        $account->save();

        return $account->toArray();
    }
}
