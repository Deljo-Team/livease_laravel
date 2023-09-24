<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNomineeRequest;
use App\Http\Requests\UpdateNomineeRequest;
use App\Interfaces\FileStorageInterface;
use App\Models\Nominee;

class NomineeController extends Controller
{
    protected $storage_path;
    public function __construct()
    {
        $this->storage_path = 'coustomer/nominees/';
    }
    public function index()
    {   
        try {
            $user = auth('sanctum')->user();
            $user_id = $user->id;
    
            $nominee = Nominee::where('user_id', $user_id)->get();
    
            return response()->json([
                'Success' => true,
                'Message' => 'Nominee for the user fetched successfully',
                'Title'   => 'Success',
                'Data'    => $nominee,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to fetch nominee',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }
    public function storeOrUpdate(StoreNomineeRequest $request, FileStorageInterface $storage)
    {
        $user = auth('sanctum')->user();
        $user_id = $user->id;

        try {
            $nominee = Nominee::where('user_id', $user_id)->first();

            if (!$nominee) {
                $nominee = new Nominee();
                $nominee->user_id = $user_id;
            }
            $nominee->name = $request->name;
            $nominee->address = $request->address;
            $nominee->phone = $request->phone;
            $nominee->account_no = $request->account_no;
            $nominee->ifsc = $request->ifsc;
            $nominee->image = $request->image;
            $nominee->percentage = 100;

            if ($request->hasFile('image')) {
                $imagePath = $storage->saveFile($request->file('image'), $this->storage_path . $user_id, 'image.' . $request->file('image')->extension());
                $nominee->image = $imagePath;
            }

            $nominee->save();

            $imageUrl = $nominee->image ? config('app.url') . $storage->getFileUrl($nominee->image) : null;
            
            return response()->json([
                'Success' => true,
                'Message' => 'Nominee ' . ($nominee->wasRecentlyCreated ? 'created' : 'updated') . ' successfully',
                'Title'   => 'Success',
                'Data' => $nominee,
                'Image' => $imageUrl,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Nominee ' . ($nominee->wasRecentlyCreated ? 'creation' : 'update') . ' failed',
                'Title'   => 'Error',
                'Data' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(FileStorageInterface $storage)
    {
        try {
            $user = auth('sanctum')->user();
            $user_id = $user->id;
            
            $nominee = Nominee::where('user_id', $user_id)->first();
            if($nominee) {
                $storage->deleteFile($nominee->getRawOriginal('image'));
                $nominee->delete();
        
                return response()->json([
                    'Success' => true,
                    'Message' => 'Nominee deleted successfully',
                    'Title'   => 'Success',
                ], 200);
            }    
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to delete nominee',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }
    }
}
