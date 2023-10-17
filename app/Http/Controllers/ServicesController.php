<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServicesRequest;
use App\Http\Requests\UpdateServicesRequest;
use App\Models\Services;
use App\Models\ServiceAnswer;
use App\Models\SubCategoryQuestion;

class ServicesController extends Controller
{
    public function index()
    {
        try {
            $user = auth('sanctum')->user();
            $user_id = $user->id;
    
            $services = Services::where('user_id', $user_id)
            ->where('status', '!=', 'complete')
            ->where('status', '!=', 'rejected')
            ->orderBy('created_at', 'desc') 
            ->get();
    
            return response()->json([
                'Success' => true,
                'Message' => 'Services fetched successfully',
                'Title'   => 'Success',
                'Data'    => $services,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to fetch services',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }

    public function getServiceDetails($serviceId)
    {
        try {
            $user = auth('sanctum')->user();
            $user_id = $user->id;
    
            $service = Services::where('id', $serviceId)
            ->get();
            $serviceDetails = ServiceAnswer::where('service_id', $serviceId)
            ->get();

            $questionIds = $serviceDetails->unique('questions_id')->pluck('questions_id');
            $questionDetails = SubCategoryQuestion::whereIn('id', $questionIds)->get();
            // dd();

            return response()->json([
                'Success' => true,
                'Message' => 'Service details fetched successfully',
                'Title'   => 'Success',
                'Data'    => [
                    'service' => $service,
                    'serviceDetails' => $serviceDetails,
                    'questionDetails' => $questionDetails 
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to fetch service details',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }

    public function store(StoreServicesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Services $services)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Services $services)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServicesRequest $request, Services $services)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Services $services)
    {
        //
    }
}
