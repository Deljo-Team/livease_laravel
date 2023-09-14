<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceMenCreateRequest;
use App\Http\Requests\ServiceMenDeleteRequest;
use App\Http\Requests\ServiceMenEditRequest;
use App\Interfaces\FileStorageInterface;
use App\Models\Servicemen;
use App\Models\User;
use App\Models\VendorCompany;
use Illuminate\Http\Request;

class ServicemenController extends Controller
{
    protected $storage_path;
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->storage_path = 'vendor/servicemen/id_proof/';
    }
    public function index(Request $request)
    {
        $user = auth('sanctum')->user();
        $service_man = Servicemen::where('vendor_company_id', $user->vendor_company->id)->with('categories', 'sub_categories')->get();
        $service_man->each(function ($serviceMan) {
            foreach ($serviceMan->categories as $category) {
                $category->sub_categories = $serviceMan->sub_categories->where('category_id', $category->id);
            }
            $serviceMan->unsetRelation('sub_categories');
        });
        return response()->json([
            'Success' => true,
            'Message' => 'Service Men list fetched successfully',
            'Title'   => 'Success',
            'Data' => $service_man,
        ], 200);
    }



    public function store(ServiceMenCreateRequest $request, FileStorageInterface $storage)
    {
        $user = auth('sanctum')->user();
        if (!$user->vendor_company) {
            return response()->json([
                'Success' => false,
                'Message' => 'You are not a vendor',
                'Title'   => 'Failed',
                'Data' => [],
            ], 403);
        }
        if ($user->vendor_company->is_admin_verified != 1) {
            return response()->json([
                'Success' => false,
                'Message' => 'Your company is not verified by admin',
                'Title'   => 'Failed',
                'Data' => [],
            ], 403);
        }
        $customer = User::where('email', $request->email)->where('type', 'customer')->get()->first();
        if (!$customer) {
            return response()->json([
                'Success' => false,
                'Message' => 'No valid customer found',
                'Title'   => 'Failed',
                'Data' => [],
            ], 403);
        }
        $vendor_company_id = $user->vendor_company->id;
        $file_name = $request->name . '_' . time() . ".";
        $id_proof = $storage->saveFile($request->file('id_proof'), $this->storage_path . $vendor_company_id, $file_name . $request->file('id_proof')->extension());
        $data = array(
            'name' => $request->name,
            'user_id' => $customer->id,
            'vendor_company_id' => $vendor_company_id,
            'id_proof' => $id_proof,
            'is_available' => 0,
            'is_verified' => 0,
        );
        $service_man = Servicemen::create($data);
        $service_man->categories()->attach($request->category);
        $service_man->sub_categories()->attach($request->sub_category);

        foreach ($service_man->categories as $category) {
            $category->sub_categories = $service_man->sub_categories->where('category_id', $category->id);
        }
        $service_man->unsetRelation('sub_categories');

        return response()->json([
            'Success' => true,
            'Message' => 'Service Men created successfully',
            'Title'   => 'Success',
            'Data' => $service_man,
        ], 201);
    }



    public function update(ServiceMenEditRequest $request, FileStorageInterface $storage)
    {
        $user = auth('sanctum')->user();
        if (!$user->vendor_company) {
            return response()->json([
                'Success' => false,
                'Message' => 'You are not a vendor',
                'Title'   => 'Failed',
                'Data' => [],
            ], 403);
        }
        if ($user->vendor_company->is_admin_verified != 1) {
            return response()->json([
                'Success' => false,
                'Message' => 'Your company is not verified by admin',
                'Title'   => 'Failed',
                'Data' => [],
            ], 403);
        }

        $vendor_company_id = $user->vendor_company->id;
        $service_man = Servicemen::where('id', $request->id)->first();
        if (!$service_man) {
            return response()->json([
                'Success' => false,
                'Message' => 'No valid servicemen found',
                'Title'   => 'Failed',
                'Data' => [],
            ], 403);
        }
        $data = $request->except(['id_proof', 'categories', 'sub_categories', 'email']);
        if ($request->email) {

            $customer = User::where('email', $request->email)->where('type', 'customer')->get()->first();
            if (!$customer) {
                return response()->json([
                    'Success' => false,
                    'Message' => 'No valid customer found',
                    'Title'   => 'Failed',
                    'Data' => [],
                ], 403);
            }
            $data['user_id'] = $customer->id;
        }
        if ($request->id_proof != null) {
            $old_file = $service_man->getRawOriginal('id_proof');
            $file_name = $request->name . '_' . time() . ".";
            $id_proof = $storage->saveFile($request->file('id_proof'), $this->storage_path . $vendor_company_id, $file_name . $request->file('id_proof')->extension());
            $data['id_proof'] = $id_proof;
            //delete the old file
            $storage->deleteFile($old_file);
        }
        $service_man->update($data);
        if ($request->category && count($request->category)) {
            $service_man->categories()->sync($request->category);
        }
        if ($request->sub_category && count($request->sub_category)) {
            $service_man->sub_categories()->sync($request->sub_category);
        }
        $service_man = Servicemen::where('id', $request->id)->first();

        foreach ($service_man->categories as $category) {
            $category->sub_categories = $service_man->sub_categories->where('category_id', $category->id);
        }
        $service_man->unsetRelation('sub_categories');

        return response()->json([
            'Success' => true,
            'Message' => 'Service Men updated successfully',
            'Title'   => 'Success',
            'Data' => $service_man,
        ], 201);
    }

    public function destroy(Request $request, $id, FileStorageInterface $storage)
    {
        // TODO::check if servicemen is assigned to any job
        $user = auth('sanctum')->user();
        if (!$user->vendor_company) {
            return response()->json([
                'Success' => false,
                'Message' => 'You are not a vendor',
                'Title'   => 'Failed',
                'Data' => [],
            ], 403);
        }
        if ($user->vendor_company->is_admin_verified != 1) {
            return response()->json([
                'Success' => false,
                'Message' => 'Your company is not verified by admin',
                'Title'   => 'Failed',
                'Data' => [],
            ], 403);
        }
        if (!$id) {
            return response()->json([
                'Success' => false,
                'Message' => 'Invalid Request',
                'Title'   => 'Failed',
                'Data' => [],
            ], 401);
        }
        $service_man = Servicemen::where('id', $id)->first();
        if(!$service_man){
            return response()->json([
                'Success' => false,
                'Message' => 'No valid servicemen found',
                'Title'   => 'Failed',
                'Data' => [],
            ], 403);
        }
        if ($service_man->vendor_company_id == $user->vendor_company->id) {
            //delete the id proof
            $old_file = $service_man->getRawOriginal('id_proof');
            //delete the servicemen
            $service_man->sub_categories()->detach();
            $service_man->categories()->detach();
            $service_man->delete();
            $storage->deleteFile($old_file);
            return response()->json([
                'Success' => true,
                'Message' => 'Service man deleted successfully',
                'Title'   => 'Success',
                'Data' => [],
            ], 200);
        } else {
            return response()->json([
                'Success' => false,
                'Message' => 'Service man not belong to your company ',
                'Title'   => 'Failed',
                'Data' => [],
            ], 403);
        }
    }
}
