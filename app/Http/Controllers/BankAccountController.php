<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBankAccountRequest;
use App\Models\BankAccount;

class BankAccountController extends Controller
{
    public function index()
    {
        try {
            $user = auth('sanctum')->user();
            $user_id = $user->id;
    
            $bankAccount = BankAccount::where('user_id', $user_id)->get();
    
            return response()->json([
                'Success' => true,
                'Message' => 'Bank account for the user fetched successfully',
                'Title'   => 'Success',
                'Data'    => $bankAccount,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to fetch bank account',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }

    public function storeOrUpdate(StoreBankAccountRequest $request)
    {        
        $user = auth('sanctum')->user();
        $user_id = $user->id;

        try {
            $bankAccount = BankAccount::where('user_id', $user_id)->first();

            if (!$bankAccount) {
                $bankAccount = new BankAccount();
                $bankAccount->user_id = $user_id;
            }
            $bankAccount->bank_name = $request->bank_name;
            $bankAccount->account_no = $request->account_no;
            $bankAccount->name = $request->name;
            $bankAccount->branch_name = $request->branch_name;
            $bankAccount->IBAN = $request->IBAN;
            $bankAccount->nominee = $request->nominee;
            $bankAccount->status = $request->status;
            $bankAccount->save();

            return response()->json([
                'Success' => true,
                'Message' => 'Bank account ' . ($bankAccount->wasRecentlyCreated ? 'created' : 'updated') . ' successfully',
                'Title'   => 'Success',
                'Data' => $bankAccount
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Bank account ' . ($bankAccount->wasRecentlyCreated ? 'creation' : 'update') . ' failed',
                'Title'   => 'Error',
                'Data' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function destroy($bank_account_id)
    {
        try {
            $user = auth('sanctum')->user();
            $user_id = $user->id;
            
            $bankAccount = BankAccount::where('user_id', $user_id)
                ->findOrFail($bank_account_id);
            $bankAccount->delete();
    
            return response()->json([
                'Success' => true,
                'Message' => 'Bank account deleted successfully',
                'Title'   => 'Success',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to delete bank account',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }
}
