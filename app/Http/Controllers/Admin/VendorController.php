<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\VendorApprovalDataTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VendorCompany;

class VendorController extends Controller
{
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(VendorCompany $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VendorCompany $vendor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VendorCompany $vendor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VendorCompany $vendor)
    {
        //
    }
}
