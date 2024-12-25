<?php

namespace App\Enum;

enum TransactionEnum: string {
    case P = 'Pix';
    case C = 'Cartão de Crédito';
    case D = ' Cartão de Débito';
    case S = ' Sque em Caixa Eletrônico';

    /**
     * @return array
     */
    public static function toArray(): array
    {
        return [
            self::P->name,
            self::C->name,
            self::D->name,
            self::S->name
        ];
    }
}