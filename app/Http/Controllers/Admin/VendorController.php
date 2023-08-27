<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\VendorApprovalDataTable;
use App\DataTables\VendorListDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VendorCompany;

class VendorController extends Controller
{
      /**
     * Display a listing of the resource.
     */
    public function index(VendorListDataTable $dataTable)
    {
        return $dataTable->render('admin.pages.vendor_approval.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function approve(VendorApprovalDataTable $dataTable)
    {
        return $dataTable->render('admin.pages.vendor_approval.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|in:approve,reject',
            'id' => 'required|exists:vendor_companies,id',
        ]);
        $is_admin_verified = 1;
        $status = 0;
        $return_string = 'Vendor Rejected Successfully';
        if($request->status == 'approve')
        {
            $status = 1;
            $return_string = 'Vendor Approved Successfully';

        }
        $vendor = VendorCompany::where('id', $request->id)->first();
        if(!$vendor)
        {
            $return_data = [
                'success' => false,
                'message' => 'Vendor Not Found',
                'title' => 'Error',
            ];
            return response()->json($return_data, 404);
        }
        try {
            $vendor->update(['status' => $status, 'is_admin_verified' => $is_admin_verified]);
        
            $return_data = [
                'success' => true,
                'message' => $return_string,
                'title' => 'Success',
            ];
            return response()->json($return_data, 200);
        } catch (\Throwable $th) {
            //throw $th;
            $return_data = [
                'success' => false,
                'message' => $th->getMessage(),
                'title' => 'Error',
            ];
            return response()->json($return_data, 500);
        }
       
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $vendor_details = [
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'company_type' => 'Company Type',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
        $user_details = [
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'profile_pic' => 'Profile Pic',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
        $vendor = VendorCompany::where('id', $request->id)->first();
        $user = $vendor->user;
        $category = $vendor->categories()->with('sub_categories')->get()->toArray();
        foreach($category as $key => $value)
        {
            $category[$key]['name'] = $value['name'];

            $category[$key]['sub_categories'] = implode(', ', array_column($value['sub_categories'], 'name'));
        }
        
        return view('admin.pages.vendor_approval.view', compact('vendor','user','category', 'vendor_details', 'user_details'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VendorCompany $vendor)
    {
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VendorCompany $vendor)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VendorCompany $vendor)
    {
        //
    }
}
