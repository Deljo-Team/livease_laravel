<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorejobTypeRequest;
use App\Models\jobType;

class JobTypeController extends Controller
{
    public function index()
    {
        try {    
            $jobType = jobType::all();
    
            return response()->json([
                'Success' => true,
                'Message' => 'Job type fetched successfully',
                'Title'   => 'Success',
                'Data'    => $jobType,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to fetch jobType',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }

    public function storeOrUpdate(StorejobTypeRequest $request)
    {        
        try {
            if (!$request->id) {
                $jobType = new jobType();
            } else {
                $jobType = jobType::where('id', $request->id)->first();
            }
            $jobType->job_type = $request->job_type;
            $jobType->status = $request->status;

            $jobType->save();

            return response()->json([
                'Success' => true,
                'Message' => 'Job type ' . ($jobType->wasRecentlyCreated ? 'created' : 'updated') . ' successfully',
                'Title'   => 'Success',
                'Data' => $jobType,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Job type ' . ($jobType->wasRecentlyCreated ? 'creation' : 'update') . ' failed',
                'Title'   => 'Error',
                'Data' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function destroy($visa_id)
    {
        try {
            $jobType = jobType::where('id', $visa_id)->first();
            if($jobType) {
                $jobType->delete();
        
                return response()->json([
                    'Success' => true,
                    'Message' => 'Job type deleted successfully',
                    'Title'   => 'Success',
                ], 200);
            }    
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to delete jobType',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }
}
