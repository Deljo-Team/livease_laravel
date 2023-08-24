<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // public static function boot() {
    //     parent::boot();

    //     static::created(function ($transaction) {
    //         $curentBalance = $transaction->user->balance;
    //         $transaction_type = $transaction->type;
    //         $transaction_amount = $transaction->amount;
    //         $transaction->user->update([
    //             'balance' => $transaction_type == 'credit' ? $curentBalance + $transaction_amount : $curentBalance - $transaction_amount
    //         ]);
    //     });
    //     static::updating(function ($transaction) {
    //         $curentBalance = $transaction->user->balance;
    //         $id = $transaction->id;
    //         $currentTransaction = Transaction::find($id);
    //         $transaction_type = $currentTransaction->type;
    //         $transaction_amount = $currentTransaction->amount;
    //         $transaction->user->update([
    //             'balance' => $transaction_type == 'credit' ? $curentBalance - $transaction_amount : $curentBalance + $transaction_amount
    //         ]);
    //     });
    //     static::updated(function ($transaction) {
    //         $curentBalance = $transaction->user->balance;
    //         $transaction_type = $transaction->type;
    //         $transaction_amount = $transaction->amount;
    //         $transaction->user->update([
    //             'balance' => $transaction_type == 'credit' ? $curentBalance + $transaction_amount : $curentBalance - $transaction_amount
    //         ]);
    //     });
    //     static::deleted(function ($transaction) {
    //         $curentBalance = $transaction->user->balance;
    //         $transaction_type = $transaction->type;
    //         $transaction_amount = $transaction->amount;
    //         $transaction->user->update([
    //             'balance' => $transaction_type == 'credit' ? $curentBalance - $transaction_amount : $curentBalance + $transaction_amount
    //         ]);
    //     });
    // }

    protected $fillable = [
        'user_id',
        'vendor_company_id',
        'type',
        'amount',
        'status',
        'remarks',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

