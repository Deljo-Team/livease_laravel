<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuotationRequest;
use App\Http\Requests\UpdateQuotationRequest;
use App\Models\Quotation;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $service_id = $request->service_id;
        $quotations = Quotation::where('service_id', $service_id)->where('status','pending')->get();
        return response()->json([
            'Success' => true,
            'Message' => 'Quotations fetched successfully',
            'Title'   => 'Success',
            'Data'    => $quotations,
        ], 200);
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
    public function store(StoreQuotationRequest $request)
    {
        //create quotation_number 

        //
        $quotation = new Quotation();
        $quotation->service_id = $request->service_id;
        $quotation->service_name = $request->service_name;
        $quotation->quotation_amount = $request->quotation_amount;
        $quotation->site_inspection = $request->site_inspection;
        $quotation->status = $request->status;
        $quotation->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Quotation $quotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quotation $quotation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuotationRequest $request, Quotation $quotation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quotation $quotation)
    {
        //
    }
}
