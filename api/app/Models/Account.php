<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * @var array $visible
     */
    protected $visible = [
        'id',
        'numero_conta',
        'saldo'
    ];

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'numero_conta',
        'saldo'
    ];
}
