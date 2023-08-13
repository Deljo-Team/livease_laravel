<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceMenCreateRequest;
use App\Http\Requests\ServiceMenDeleteRequest;
use App\Http\Requests\ServiceMenEditRequest;
use App\Models\Servicemen;
use App\Models\VendorCompany;
use Illuminate\Http\Request;

class ServicemenController extends Controller
{
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

    

    public function store(ServiceMenCreateRequest $request)
    {
        $service_man = Servicemen::create($request->all());

        return response()->json([
            'Success' => true,
            'Message' => 'Service Men created successfully',
            'Title'   => 'Success',
            'Data' => $service_man,
        ],201);
        
    }



    public function update(ServiceMenEditRequest $request)
    {
        $service_man = Servicemen::where('id', $request->id)->first();
        $service_man->update($request->all());

        return response()->json([
            'Success' => true,
            'Message' => 'Service Men updated successfully',
            'Title'   => 'Success',
            'Data' => $service_man,
        ],201);
    }

    public function destroy($id)
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
            //delete the servicemen
            $service_man->delete();
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
