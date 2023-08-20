<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionDeleteRequest;
use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Models\VendorCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // protected $user_id, $vendor_company_id;
    public function __construct()
    {
        // //get the vendor from Auth
        // $user = auth('sanctum')->user();
        // $user_id = $user->id;
        // $vendor_company = VendorCompany::where('user_id', $user_id)->first();
        // $vendor_company_id = $vendor_company->id;
    }
    public function index(TransactionRequest $request)
    {
        $user = auth('sanctum')->user();
        $user_id = $user->id;
        $vendor_company = VendorCompany::where('user_id', $user_id)->first();
        $vendor_company_id = $vendor_company->id;
        //list the trasactions
        $base_query = Transaction::where('vendor_company_id', $vendor_company_id)
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc');
        if($request->start_date){
            $base_query->whereDate('created_at', '>=', $request->start_date);
        }
        if($request->end_date){
            $base_query->whereDate('created_at', '<=', $request->end_date);
        }
        if($request->status){
            $base_query->where('status', $request->status);
        }
        $base_query = $base_query->get();
            $grouped = $base_query->mapToGroups(function ($item, $key) {
                return [$item['type'] => $item];
            });
             
            $income = $grouped->get('credit') ?? [];
            $expense = $grouped->get('debit') ?? [];
            if($income != null && $income->count() > 0){
                $total_income = $income->sum('amount');
            }else{
                $total_income = 0;
            }
            if($expense!= null && $expense->count() > 0){
                $total_expense = $expense->sum('amount');
            }else{
                $total_expense = 0;
            }
            $balance = $total_income - $total_expense;
        // $balance = $income->sum('amount') ?? 0 - $expense->sum('amount') ?? 0;
        return response()->json([
            'Success' => true,
            'Message' => 'Transactions fetched successfully',
            'Title'   => 'Success',
            'Data' => [
                'income' => $income,
                'expense' => $expense,
                'balance' => $balance,
            ],
        ], 200);
    }

    public function create(TransactionRequest $request)
    {
        $user = auth('sanctum')->user();
        $user_id = $user->id;
        $vendor_company = VendorCompany::where('user_id', $user_id)->first();
        $vendor_company_id = $vendor_company->id;
        try {
            $transaction = new Transaction();
            $transaction->vendor_company_id = $vendor_company_id;
            $transaction->user_id = $user_id;
            $transaction->service_id = $request->service_id ?? NULL;
            $transaction->type = $request->type;
            $transaction->amount = $request->amount;
            $transaction->currency = $request->currency ?? NULL;
            $transaction->description = $request->description;
            $transaction->status = $request->status ?? 'pending';
            $transaction->save();
            return response()->json([
                'Success' => true,
                'Message' => 'Transaction created successfully',
                'Title'   => 'Success',
                'Data' => $transaction,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Transaction creation failed',
                'Title'   => 'Error',
                'Data' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(TransactionDeleteRequest $request)
    {
        $user = auth('sanctum')->user();
        $user_id = $user->id;
        $vendor_company = VendorCompany::where('user_id', $user_id)->first();
        $vendor_company_id = $vendor_company->id;
        try {
            $transaction = Transaction::where('id', $request->id)
                ->where('vendor_company_id', $vendor_company_id)
                ->where('user_id', $user_id)
                ->first();
            if ($transaction) {
                $transaction->delete();
                return response()->json([
                    'Success' => true,
                    'Message' => 'Transaction deleted successfully',
                    'Title'   => 'Success',
                    'Data' => $transaction,
                ], 200);
            } else {
                return response()->json([
                    'Success' => false,
                    'Message' => 'Transaction not found',
                    'Title'   => 'Error',
                    'Data' => null,
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Transaction deletion failed',
                'Title'   => 'Error',
                'Data' => $e->getMessage(),
            ], 500);
        }
    }
    // TODO: check if the transaction belongs to the vendor



        
    
}
