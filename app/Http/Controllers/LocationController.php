<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationApiRequest;
use App\Models\Location;
use App\Models\SubLocation;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    //

    public function index(LocationApiRequest $request)
    {
        $country_id = $request->country_id;
        $locations = Location::with('sub_locations')->where('country_id', $country_id)->get();
        return response()->json([
            'Success' => true,
            'Message' => 'Location List',
            'Title' => 'Success',
            'Data' => ['location'=>$locations]
        ], 200);
    }

    public function viewSubLocations(Request $request)
    {
        $location_id = $request->location_id;
        $sub_locations = SubLocation::with('location.country')->where('location_id', $location_id)->get();
        return response()->json([
            'Success' => true,
            'Message' => 'Sub Location List',
            'Title' => 'Success',
            'Data' => ['sub_locations'=>$sub_locations]
        ], 200);
    }
}
