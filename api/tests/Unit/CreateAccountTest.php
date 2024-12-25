<?php

namespace Tests\Unit;

use App\Application\CreateAccount;
use App\Application\VerifyAccountNumberExists;
use App\Models\Account;
use Exception;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateAccountTest extends TestCase
{
    use DatabaseMigrations;

    public function testCreateAccountSuccess()
    {
        $expected = [
            'numero_conta' => '1',
            'saldo' => 1000,
            'id' => 1
        ];
        $input = [
            'numero_conta' => '1',
            'saldo' => 1000
        ];

        $accountMock = $this->createMock(Account::class);
        $accountMock->expects($this->any())
                    ->method('save')
                    ->willReturn(true);
        $accountMock->expects($this->any())
                    ->method('toArray')
                    ->willReturn($input);

        $createAccount = $this->getMockBuilder(CreateAccount::class)
                              ->setConstructorArgs([$input])
                              ->onlyMethods(['validateFields'])
                              ->getMock();

        $verifyAccountNumberExists = $this->getMockBuilder(VerifyAccountNumberExists::class)
                                          ->onlyMethods(['verify'])
                                          ->getMock();
        $verifyAccountNumberExists->expects($this->any())
                                  ->method('verify')
                                  ->with($input['numero_conta'])
                                  ->willReturn(true);

        $createAccount->expects($this->once())
                      ->method('validateFields')
                      ->with($input)
                      ->willReturn(true);

        $result = $createAccount->create();
        $this->assertEquals($expected, $result);
    }

    public function testCreateAccountMissingField()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Campo obrigatório não enviado.');
        $this->expectExceptionCode(400);

        $input = [
            'numero_conta' => '123456'
        ];

        $createAccount = new CreateAccount($input);
        $createAccount->create();
    }

    /* public function testCreateAccountNumberExists()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Número da conta já existe.');
        $this->expectExceptionCode(400);

        $input = [
            'numero_conta' => '1',
            'saldo' => 1000
        ];

        $createAccount = $this->getMockBuilder(CreateAccount::class)
                              ->setConstructorArgs([$input])
                              ->onlyMethods(['validateFields'])
                              ->getMock();

        $verifyAccountNumberExists = $this->getMockBuilder(VerifyAccountNumberExists::class)
                                        ->onlyMethods(['verify'])
                                        ->getMock();
        $verifyAccountNumberExists->expects($this->once())
                                ->method('verify')
                                ->with('numero_conta', $input['numero_conta'])
                                ->willReturn(true);

        $createAccount->expects($this->once())
                      ->method('validateFields')
                      ->with($input)
                      ->willReturn(true);

        $createAccount->create();
    } */
}
