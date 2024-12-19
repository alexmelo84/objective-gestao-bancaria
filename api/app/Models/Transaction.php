<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'id_account',
        'forma_pagamento',
        'valor'
    ];
}
