<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorejobRequest;
use App\Models\job;

class JobController extends Controller
{
    public function index()
    {
        try {    
            $job = job::all();
    
            return response()->json([
                'Success' => true,
                'Message' => 'Job fetched successfully',
                'Title'   => 'Success',
                'Data'    => $job,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to fetch job',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }

    public function storeOrUpdate(StorejobRequest $request)
    {        
        try {
            if (!$request->id) {
                $job = new job();
            } else {
                $job = job::where('id', $request->id)->first();
            }
            $job->job = $request->job;
            $job->status = $request->status;

            $job->save();

            return response()->json([
                'Success' => true,
                'Message' => 'Job ' . ($job->wasRecentlyCreated ? 'created' : 'updated') . ' successfully',
                'Title'   => 'Success',
                'Data' => $job,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Job ' . ($job->wasRecentlyCreated ? 'creation' : 'update') . ' failed',
                'Title'   => 'Error',
                'Data' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function destroy($visa_id)
    {
        try {
            $job = job::where('id', $visa_id)->first();
            if($job) {
                $job->delete();
        
                return response()->json([
                    'Success' => true,
                    'Message' => 'Job deleted successfully',
                    'Title'   => 'Success',
                ], 200);
            }    
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to delete job',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }
}
