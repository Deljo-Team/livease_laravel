<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRewardTransactionsRequest;
use App\Models\RewardTransactions;
use App\Models\Rewards;
use App\Models\Service;

class RewardTransactionsController extends Controller
{
    public function index()
    {
        try {
            $user = auth('sanctum')->user();
            $rewardAmount = $user->reward_amount;
            $rewardPoint = $user->reward_point;
            return response()->json([
                'Success' => true,
                'Message' => 'Reward points for the user fetched successfully',
                'Title'   => 'Success',
                'Data'    => [
                    'reward_amount' => $rewardAmount,
                    'reward_point' => $rewardPoint
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to fetch rewards',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }

    public function transactionList() {
        try{
            $user = auth('sanctum')->user();
            $user_id = $user->id;
    
            $rewardTransactions = RewardTransactions::where('user_id', $user_id)
                ->get();

            return response()->json([
                'Success' => true,
                'Message' => 'Reward transactions for the user fetched successfully',
                'Title'   => 'Success',
                'Data'    => [
                    'reward_transactions' => $rewardTransactions,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to fetch rewards transactions',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
        

    }
    
    public function store(StoreRewardTransactionsRequest $request)
    {
        $user = auth('sanctum')->user();
        $user_id = $user->id;

        try {
            
            $rewardTransactions = new RewardTransactions();

            $reward = Rewards::find($request->reward_id);

            if($reward->reward_type == 'percentage') {
                $service = Service::find($request->service_id);
                $points = ($service->amount * $reward->value) / 100;
                $rewardTransactions->points = round($points);
            } else {
                $rewardTransactions->points = $reward->value;
            }

            $rewardTransactions->user_id = $user_id;
            $rewardTransactions->service_id = $request->service_id;
            $rewardTransactions->reward_id = $request->reward_id;
            $rewardTransactions->transaction_type = $request->transaction_type;
            $rewardTransactions->status = $request->status;
            $rewardTransactions->save();

            return response()->json([
                'Success' => true,
                'Message' => 'Reward transactions added successfully',
                'Title'   => 'Success',
                'Data' => $rewardTransactions
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Reward transaction adding failed',
                'Title'   => 'Error',
                'Data' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($reward_transactions_id)
    {
        try {
            $user = auth('sanctum')->user();
            $user_id = $user->id;
            
            $rewardTransactions = RewardTransactions::where('user_id', $user_id)
                ->findOrFail($reward_transactions_id);
    
            $rewardTransactions->delete();
    
            return response()->json([
                'Success' => true,
                'Message' => 'Reward transaction deleted successfully',
                'Title'   => 'Success',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to delete reward transaction',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }
}
