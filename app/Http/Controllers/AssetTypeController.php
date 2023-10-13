<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssetTypeRequest;
use App\Http\Requests\UpdateAssetTypeRequest;
use App\Models\AssetType;

class AssetTypeController extends Controller
{
    public function index()
    {
        try {
            $jobApplications = AssetType::get();
    
            return response()->json([
                'Success' => true,
                'Message' => 'Asset type fetched successfully',
                'Title'   => 'Success',
                'Data'    => $jobApplications,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to fetch asset type',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }
}
