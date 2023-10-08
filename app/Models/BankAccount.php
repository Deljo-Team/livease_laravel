<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'bank_name',
        'account_no',
        'name',
        'branch_name',
        'IBAN',
        'Nominee',
        'status'
    ];
}