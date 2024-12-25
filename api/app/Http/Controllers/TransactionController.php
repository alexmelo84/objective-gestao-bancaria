<?php

namespace App\Http\Controllers;

use App\Application\CreateTransaction;
use App\Application\WithdrawAtm;
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

    /**
     * Withdraw ATM
     * 
     * Escreva uma aplicação que simule a entrega de notas de um caixa eletrônico.Os requisitos básicos são:- Entregar o MENOR número de notas;
     * Notas disponíveis de R$ 100,00; R$ 50,00; R$ 20,00 e R$ 10,00
     * Saldo do cliente infinito;
     * Quantidade de notas infinita;
     * Se o valor solicitado for menor que a nota mais baixa, apresentar mensagem "Valor não disponível para saque"
     * Se o valor solicitado conter centavos (float), apresentar mensagem "Valor não disponível para saque"
     * A saída da aplicação deve ser o seguinte padrão:
     *     1 nota(s) de R$ 100,00
     *     1 nota(s) de R$ 50,00
     *     1 nota(s) de R$ 20,00
     *     1 nota(s) de R$ 10,00 SUGESTÃO DE teste com os seguintes valor
     * 
     * @var Request $request
     * @return string
     */
    public function withdrawAtm(Request $request): string
    {
        $withdrawAtm = new WithdrawAtm(
            $request->forma_pagamento,
            $request->numero_conta,
            $request->valor
        );

        return response()->json($withdrawAtm->withdraw(), 200)->getContent();
    }

    /**
     * Sque
     */
    /**
     * <?php

# Escreva uma aplicação que simule a entrega de notas de um caixa eletrônico.Os requisitos básicos são:- Entregar o MENOR número de notas;
#- Notas disponíveis de R$ 100,00; R$ 50,00; R$ 20,00 e R$ 10,00
#- Saldo do cliente infinito;
#- Quantidade de notas infinita;
#- Se o valor solicitado for menor que a nota mais baixa, apresentar mensagem "Valor não disponível para saque"
#- Se o valor solicitado conter centavos (float), apresentar mensagem "Valor não disponível para saque"
#- A saída da aplicação deve ser o seguinte padrão:
#     1 nota(s) de R$ 100,00
#     1 nota(s) de R$ 50,00
#     1 nota(s) de R$ 20,00
#     1 nota(s) de R$ 10,00 SUGESTÃO DE teste com os seguintes valor
// function processaSaque($valorDesejado) {
//     $notasDisponiveis = [100, 50, 20, 10];

//     if (is_float($valorDesejado)) {
//         return 'Valor inválido';
//     } else if ($valorDesejado % 10 !== 0) {
//         return 'Valor inferior ao disponível.';
//     }
    
//     $notasRetornadas = [];
//     $saldoRestante = [];

//     foreach ($notasDisponiveis as $nota) {
//         calculaNotas($valorDesejado, $nota);
//     }
    
//     return $notasRetornadas;
// }

// function calculaNotas($valorDesejado, $nota) {
//     if ($valorDesejado >= $nota) {
//         $notasRetornadas[] = $nota;
        
//         $valorDesejado -= $nota;
        
//     }
// }

// var_dump(processaSaque(470));
     */
}
