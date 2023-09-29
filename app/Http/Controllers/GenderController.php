<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoregenderRequest;
use App\Http\Requests\UpdategenderRequest;
use App\Models\gender;

class GenderController extends Controller
{
    public function index()
    {
        try {    
            $gender = gender::all();
    
            return response()->json([
                'Success' => true,
                'Message' => 'Gender fetched successfully',
                'Title'   => 'Success',
                'Data'    => $gender,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to fetch gender',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }

    public function storeOrUpdate(StoregenderRequest $request)
    {        
        try {
            
            if (!$request->id) {
                $gender = new gender();
            } else {
                $gender = gender::where('id', $request->id)->first();
            }
            $gender->gender = $request->gender;
            $gender->status = $request->status;

            $gender->save();

            return response()->json([
                'Success' => true,
                'Message' => 'Gender ' . ($gender->wasRecentlyCreated ? 'created' : 'updated') . ' successfully',
                'Title'   => 'Success',
                'Data' => $gender,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Gender ' . ($gender->wasRecentlyCreated ? 'creation' : 'update') . ' failed',
                'Title'   => 'Error',
                'Data' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function destroy($gender_id)
    {
        try {
            $gender = gender::where('id', $gender_id)->first();
            if($gender) {
                $gender->delete();
        
                return response()->json([
                    'Success' => true,
                    'Message' => 'Gender deleted successfully',
                    'Title'   => 'Success',
                ], 200);
            }    
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to delete gender',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }
}
