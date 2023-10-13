<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssetRequest;
use App\Models\Asset;
use App\Interfaces\FileStorageInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    protected $storage_path;
    public function __construct()
    {
        $this->storage_path = 'customer/asset/';
    }
    
    public function storeOrUpdate(StoreAssetRequest $request, FileStorageInterface $storage)
    { 
        try {
            $user = auth('sanctum')->user();
            $user_id = $user->id;

            if (!$request->id) {
                $assets = new Asset();
            } else {
                $assets = Asset::where('id', $request->id)->first();
            }
            $assets->user_id = $user_id;
            $assets->asset_types_id = $request->asset_types_id;
            $assets->asset_name = $request->asset_name;
            $assets->description = $request->description;
            $assets->service_category_id = $request->service_category_id;
            $assets->sub_category_id = $request->sub_category_id;
            $assets->reminder_date = $request->reminder_date;
            $assets->expire_date = $request->expire_date;
            $assets->date = $request->date;
            $assets->email = $request->email;
            $assets->nominee_name = $request->nominee_name;
            $assets->nominee_phone_number = $request->nominee_phone_number;
            $assets->alternative_name = $request->alternative_name;
            $assets->alternative_phone = $request->alternative_phone;            
            $assets->status = $request->status;
            $uploads = $request->uploads;
            
            $uploadsLocations = [];
            $uploadsUrls = [];

            if (is_array($uploads)) {
                foreach($uploads as $file) {
                    if (is_uploaded_file($file)) {
                        $uniqueFileName = \Ramsey\Uuid\Uuid::uuid4()->toString() . '.' . $file->extension();
                        $uploadsLocations[] = $uploadsLocation = $file->storeAs($this->storage_path . $user_id .'/'.$uniqueFileName);
                        $uploadsUrls[] = $uploadsLocation ? config('app.url') . $storage->getFileUrl($uploadsLocation) : null;
                    }
                }
            }
            $assets->uploads = json_encode($uploadsLocations);
            $assets->save();

            $assets->uploads = $uploadsLocations;
            $assets->uploadsUrls = $uploadsUrls;

            return response()->json([
                'Success' => true,
                'Message' => 'Asset ' . ($assets->wasRecentlyCreated ? 'created' : 'updated') . ' successfully',
                'Title'   => 'Success',
                'Data' => $assets
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Asset ' . ($assets->wasRecentlyCreated ? 'creation' : 'update') . ' failed',
                'Title'   => 'Error',
                'Data' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function assetsDashboard()
    {
        try {
            $user = auth('sanctum')->user();
            $user_id = $user->id;

            $summary = Asset::join('asset_types', 'assets.asset_types_id', '=', 'asset_types.id')
                ->select('asset_types.asset_type', 'assets.asset_name', 'assets.description', 'assets.status', DB::raw('count(*) as total_assets'))
                ->groupBy('asset_types.asset_type', 'assets.asset_name', 'assets.description', 'assets.status')
                ->orderBy('total_assets', 'desc') 
                ->get();

            $today = now()->toDateString();
            $tenDaysLater = now()->addDays(10)->toDateString();

            $immediatePayable = Asset::whereBetween('expire_date', [$today, $tenDaysLater])
                ->orderBy('date', 'asc')
                ->get();

            $payable = Asset::where('expire_date', '>=', $today)
                ->orderBy('date', 'asc') 
                ->get();

            return response()->json([
                'Success' => true,
                'Message' => 'Job applications for the user fetched successfully',
                'Title'   => 'Success',
                'Data'    => [
                    'immediatePayable' => $immediatePayable,
                    'payable' => $payable,
                    'summary' => $summary,
                ],
            ], 200);
        
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to fetch assets dashboard',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($assets_id, FileStorageInterface $storage)
    {
        try {
            $user = auth('sanctum')->user();
            $user_id = $user->id;
            
            $assets = Asset::where('user_id', $user_id)
                ->findOrFail($assets_id);
            if($assets) {
                $uploads = $assets->uploads;
                $uploads = $assets->getRawOriginal('uploads');
                $uploads = json_decode($uploads);
                if (is_array($uploads)) {
                    foreach($uploads as $fileLocation) {
                        $storage->deleteFile($fileLocation);
                    }
                }
            }
            $assets->delete();
    
            return response()->json([
                'Success' => true,
                'Message' => 'Asset deleted successfully',
                'Title'   => 'Success',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to delete asset',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }
}
