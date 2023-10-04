<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRewardsRequest;
use App\Models\Rewards;

class RewardsController extends Controller
{
    public function index()
    {
        try {    
            $rewards = Rewards::all();
    
            return response()->json([
                'Success' => true,
                'Message' => 'Rewards fetched successfully',
                'Title'   => 'Success',
                'Data'    => $rewards,
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

    public function storeOrUpdate(StoreRewardsRequest $request)
    {        
        try {
            if (!$request->id) {
                $rewards = new Rewards();
            } else {
                $rewards = Rewards::where('id', $request->id)->first();
            }
            $rewards->rewards = $request->rewards;
            $rewards->value = $request->value;
            $rewards->reward_type = $request->reward_type;
            $rewards->status = $request->status;

            $rewards->save();

            return response()->json([
                'Success' => true,
                'Message' => 'Rewards ' . ($rewards->wasRecentlyCreated ? 'created' : 'updated') . ' successfully',
                'Title'   => 'Success',
                'Data' => $rewards,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Rewards ' . ($rewards->wasRecentlyCreated ? 'creation' : 'update') . ' failed',
                'Title'   => 'Error',
                'Data' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function destroy($reward_id)
    {
        try {
            $rewards = Rewards::where('id', $reward_id)->first();
            if($rewards) {
                $rewards->delete();
        
                return response()->json([
                    'Success' => true,
                    'Message' => 'Rewards deleted successfully',
                    'Title'   => 'Success',
                ], 200);
            }    
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to delete rewards',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }
}
