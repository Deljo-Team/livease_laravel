<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuotationRequest;
use App\Http\Requests\UpdateQuotationRequest;
use App\Interfaces\FileStorageInterface;
use App\Models\Quotation;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    protected $storage_path, $vendor_company_id, $user_id;
    public function __construct()
    {
        $this->storage_path = 'quotation/signature/';
        $user = auth('sanctum')->user();
        $this->vendor_company_id = $user->vendor_company->id;
        $this->user_id = $user->id;

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $service_id = $request->service_id;
        $quotations = Quotation::where('vendor_company_id', $this->vendor_company_id)->where('status', 'pending')->get();
        return response()->json([
            'Success' => true,
            'Message' => 'Quotations fetched successfully',
            'Title'   => 'Success',
            'Data'    => $quotations,
        ], 200);
    }

    public function getQuotationListForUser($serviceId)
    {
        try {
            $quotations = Quotation::where('service_id', $serviceId)
            ->where('status', '!=', 'rejected')
            ->orderBy('created_at', 'desc') 
            ->get();
    
            return response()->json([
                'Success' => true,
                'Message' => 'Quotations fetched successfully',
                'Title'   => 'Success',
                'Data'    => $quotations,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to fetch quotations',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }        
    }

    public function getQuotationDetailsForUser($quotationId)
    {
        try {
            $quotation = Quotation::where('id', $quotationId)
            ->get();
    
            return response()->json([
                'Success' => true,
                'Message' => 'Quotation fetched successfully',
                'Title'   => 'Success',
                'Data'    => $quotation,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to fetch quotation',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }        
    }

    public function approveQuotation(Request $request)
    {
        try {
            $quotationId = $request->quotationId;
            $quotation = Quotation::where('id', $quotationId)
            ->first();

            if ($quotation) {
                $quotation->status = 'approved';
                $quotation->save();
            }
            
            $quotations = Quotation::where('service_id', $quotation->service_id)
            ->where('id', '!=', $quotationId)
            ->get();

            if ($quotations) {
                foreach($quotations as $quot) {
                    $quot->status = 'rejected';
                    $quot->save();
                }
            }

            return response()->json([
                'Success' => true,
                'Message' => 'Quotation approved successfully',
                'Title'   => 'Success',
                'Data'    => $quotation,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'Message' => 'Failed to approve quotation',
                'Title'   => 'Error',
                'Data'    => $e->getMessage(),
            ], 500);
        }        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuotationRequest $request, FileStorageInterface $storage)
    {
        try {
            $user = auth('sanctum')->user();
            $vendor_company_id = $user->vendor_company->id;
            if (!$vendor_company_id) {
                return response()->json([
                    'Success' => false,
                    'Message' => 'Vendor Company not found',
                ], 404);
            }
            //create quotation_number 
            //find Max quotation Number in the database
            $max_quotation_number = Quotation::where('service_id', $request->service_id)->max('quotation_number');
            if ($max_quotation_number == null) {
                $max_quotation_number = 1;
            } else {
                $max_quotation_number++;
            }
            if ($request->file('signature')) {
                $signature = $storage->saveFile($request->file('signature'), $this->storage_path . $vendor_company_id, 'signature_' . $max_quotation_number . $request->file('signature')->extension());
            }
            $quotation = new Quotation();
            $quotation->quotation_number = $max_quotation_number;
            $quotation->service_id = $request->service_id;
            $quotation->vendor_company_id = $vendor_company_id;
            $quotation->service_name = $request->service_name;
            $quotation->service_reference_number = $request->service_reference_number;
            $quotation->service_description = $request->service_description;
            $quotation->quotation_amount = $request->quotation_amount;
            $quotation->signature = $signature;
            $quotation->advance_amount = $request->advance_amount;
            $quotation->site_inspection = $request->site_inspection;
            $quotation->status = 'pending';
            $quotation->save();

            return response()->json([
                'Success' => true,
                'Message' => 'Quotation created successfully',
                'Title'   => 'Success',
                'Data'    => $quotation,
            ], 200);
        } catch (\Exception $e) {
            if(isset($signature)){
                $storage->deleteFile($signature);
            }
            return response()->json([
                'Success' => false,
                'Message' => $e->getMessage(),
                'Title'   => 'Error',
                'Data'    => [],
            ], 500);
        }
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
    public function destroy(Quotation $quotation, FileStorageInterface $storage)
    {
      try {
          //get the signature
          $signature = $quotation->signature;
          if($quotation->status != 'pending'){
            return response()->json([
                'Success' => false,
                'Message' => 'Quotation cannot be deleted',
                'Title'   => 'Error',
                'Data'    => [],
            ], 500);
          }
          //delete the signature
          $storage->deleteFile($signature);
          //delete the quotation
          $quotation->delete();
          return response()->json([
              'Success' => true,
              'Message' => 'Quotation deleted successfully',
              'Title'   => 'Success',
              'Data'    => [],
          ], 200);
      } catch (\Throwable $th) {
            return response()->json([
                'Success' => false,
                'Message' => $th->getMessage(),
                'Title'   => 'Error',
                'Data'    => [],
            ], 500); 
      }
    }
}
