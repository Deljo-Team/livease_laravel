<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceMenCreateRequest;
use App\Http\Requests\ServiceMenDeleteRequest;
use App\Http\Requests\ServiceMenEditRequest;
use App\Interfaces\FileStorageInterface;
use App\Models\Servicemen;
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
        $service_man = Servicemen::where('vendor_company_id', $user->vendor_company->id)->get();
        $service_man = $user->vendor_company->servicemen;
        return response()->json([
            'Success' => true,
            'Message' => 'Service Men list fetched successfully',
            'Title'   => 'Success',
            'Data' => $service_man,
        ], 200);
    }

    

    public function store(ServiceMenCreateRequest $request,FileStorageInterface $storage)
    {
        $user = auth('sanctum')->user();
        $vendor_company_id = $user->vendor_company->id;
        $file_name = $request->name.'_'.time().".";
        $id_proof = $storage->saveFile($request->file('id_proof'), $this->storage_path.$vendor_company_id,$file_name.$request->file('id_proof')->extension());
        $data = array(
            'name' => $request->name,
            'phone' => $request->phone,
            'vendor_company_id' => $vendor_company_id,
            'id_proof' => $id_proof,
            'category_id' => $request->category,
            'sub_category_id' => $request->sub_category,
            'is_available' => 0,
            'is_verified' => 0,
        );
        $service_man = Servicemen::create($data);

        return response()->json([
            'Success' => true,
            'Message' => 'Service Men created successfully',
            'Title'   => 'Success',
            'Data' => $service_man,
        ],201);
        
    }



    public function update(ServiceMenEditRequest $request,FileStorageInterface $storage)
    {
        $user = auth('sanctum')->user();
        $vendor_company_id = $user->vendor_company->id;
        $service_man = Servicemen::where('id', $request->id)->first();
        $data = $request->except(['id_proof']);
        if($request->id_proof != null){
            $old_file = $service_man->getRawOriginal('id_proof');
            $file_name = $request->name.'_'.time().".";
            $id_proof = $storage->saveFile($request->file('id_proof'), $this->storage_path.$vendor_company_id,$file_name.$request->file('id_proof')->extension());
            $data['id_proof'] = $id_proof;
            //delete the old file
            $storage->deleteFile($old_file);
        }
        $service_man->update($data);

        return response()->json([
            'Success' => true,
            'Message' => 'Service Men updated successfully',
            'Title'   => 'Success',
            'Data' => $service_man,
        ],201);
    }

    public function destroy(Request $request, $id,FileStorageInterface $storage)
    {
        // TODO::check if servicemen is assigned to any job
        $user = auth('sanctum')->user();

        if(!$id){
            return response()->json([
                'Success' => false,
                'Message' => 'Invallid message',
                'Title'   => 'Failed',
                'Data' => [],
            ],200);
        }
        $service_man = Servicemen::where('id', $id)->first();
        if($service_man->vendor_company_id == $user->vendor_company->id){
            //delete the id proof
            $old_file = $service_man->getRawOriginal('id_proof');
            //delete the servicemen
            $service_man->delete();
            $storage->deleteFile($old_file);
            return response()->json([
                'Success' => true,
                'Message' => 'Service man deleted successfully',
                'Title'   => 'Success',
                'Data' => [],
            ],200);
        }else{
            return response()->json([
                'Success' => false,
                'Message' => 'Service man not belong to your company ',
                'Title'   => 'Failed',
                'Data' => [],
            ],403);
        }
    }
}
