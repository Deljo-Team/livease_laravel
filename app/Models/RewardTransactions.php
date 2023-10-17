<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardTransactions extends Model
{
    use HasFactory;

    public static function boot() {
        parent::boot();
        static::created(function ($reward_transaction) {
            $rewardPointWorth = config('services.reward.rewardPointWorth');
            $user = User::find($reward_transaction->user_id);
            $curentRewardAmount = $user->reward_amount;
            $curentRewardPoint = $user->reward_point;
            $transaction_type = $reward_transaction->transaction_type;
            $transaction_point = $reward_transaction->points;
            $transaction_amount = $transaction_point * $rewardPointWorth;
            $user->update([
                'reward_amount' => $transaction_type == 'credit' ? $curentRewardAmount + $transaction_amount : $curentRewardAmount - $transaction_amount,
                'reward_point' => $transaction_type == 'credit' ? $curentRewardPoint + $transaction_point : $curentRewardPoint - $transaction_point
            ]);
        });
    }

    protected $fillable = [
        'user_id',
        'service_id',
        'reward_id',
        'transaction_type',
        'points',
        'status'
    ];
}
