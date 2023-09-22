<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileEditRequest;
use App\Models\User;
use App\Models\VendorCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VendorController extends Controller
{
    //give the vendor profile
    public function index()
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return response()->json([
                'Success' => false,
                'Message' => 'User not found',
            ], 404);
        }
        $vendor_company = VendorCompany::where('user_id', $user->id)->with('categories.sub_categories')->first();
        if (!$vendor_company) {
            return response()->json([
                'Success' => false,
                'Message' => 'Vendor profile not found',
            ], 404);
        }
        $user_id = $user->id;
        $user = User::where('id', $user_id)->with('locations', 'sub_locations')->first();
        foreach ($user->locations as $location) {
            $location->sub_categories = $user->sub_locations->where('location_id', $location->id);
        }
        $user->unsetRelation('sub_locations');

        return response()->json([
            'Success' => true,
            'Message' => 'Vendor profile fetched successfully',
            'Data' => ['vendor' => $vendor_company, 'user' => $user]
        ], 200);
    }

    //update the vendor profile
    public function updateProfile(ProfileEditRequest $request)
    {
        $user = auth('sanctum')->user();
        if (!$user) {
            return response()->json([
                'Success' => false,
                'Message' => 'User not found',
            ], 404);
        }
        $vendor_company = VendorCompany::where('user_id', $user->id)->first();
        if (!$vendor_company) {
            return response()->json([
                'Success' => false,
                'Message' => 'Vendor profile not found',
            ], 404);
        }
        //convert the base64 string to image and store it and update the vendor profile
        if ($request->logo) {
            $image = $request->logo;
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'vendor_logo_' . time() . '.' . 'png';
            File::put(public_path() . '/images/vendor/' . $imageName, base64_decode($image));
            $request->merge(['logo' => $imageName]);
        }

        $vendor_company->update($request->all());
        if($request->has('categories')){
            $vendor_company->categories()->sync($request->categories);
        }
        if($request->has('sub_categories')){
            $vendor_company->sub_categories()->sync($request->sub_categories);
        }
        $user_id = $user->id;
        $user = User::where('id', $user_id)->first();
        if($request->has('locations')){
            $user->locations()->sync($request->locations);
        }
        if($request->has('sub_locations')){
            $user->sub_locations()->sync($request->sub_locations);
        }
        foreach ($user->locations as $location) {
            $location->sub_categories = $user->sub_locations->where('location_id', $location->id);
        }
        $user->unsetRelation('sub_locations');
        
        return response()->json([
            'Success' => true,
            'Message' => 'Vendor profile updated successfully',
            'Data' => ['vendor' => $vendor_company, 'user' => $user]
        ], 200);
    }
}
