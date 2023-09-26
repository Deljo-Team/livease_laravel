<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorevisaRequest;
use App\Models\visa;

class VisaController extends Controller
{
    public function index()
    {
        try {    
            $visa = visa::all();
    
            return response()->json([
                'Success' => true,
                'Message' => 'Visa fetched successfully',
                'Title'   => 'Success',
                'Data'    => $visa,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to fetch visa',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }

    public function storeOrUpdate(StorevisaRequest $request)
    {        
        try {
            
            if (!$request->id) {
                $visa = new visa();
            } else {
                $visa = visa::where('id', $request->id)->first();
            }
            $visa->visa = $request->visa;
            $visa->status = $request->status;

            $visa->save();

            return response()->json([
                'Success' => true,
                'Message' => 'Visa ' . ($visa->wasRecentlyCreated ? 'created' : 'updated') . ' successfully',
                'Title'   => 'Success',
                'Data' => $visa,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Visa ' . ($visa->wasRecentlyCreated ? 'creation' : 'update') . ' failed',
                'Title'   => 'Error',
                'Data' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function destroy($visa_id)
    {
        try {
            $visa = visa::where('id', $visa_id)->first();
            if($visa) {
                $visa->delete();
        
                return response()->json([
                    'Success' => true,
                    'Message' => 'Visa deleted successfully',
                    'Title'   => 'Success',
                ], 200);
            }    
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to delete visa',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }
}
