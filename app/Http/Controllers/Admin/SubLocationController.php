<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SubLocationsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\SubLocation;
use App\Services\GeneralServices;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubLocationController extends Controller
{
    protected $services;
    public function __construct()
    {
        $this->services = new GeneralServices();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(SubLocationsDataTable $dataTable)
    {
        return $dataTable->render('admin.pages.sub_locations.index');
    }
   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::all();
        return view('admin.pages.sub_locations.create', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:sub_locations|max:255',
            'location' => 'required|exists:locations,id',
        ]);

        try {
            $sub_location = new SubLocation();
            $sub_location->name = $request->name;
            $sub_location->location_id = $request->location;
            $sub_location->slug = $this->services->slugify($request->name);
            $sub_location->save();
            return response()->json(['success' => 1, 'message' => 'Sub Location added successfully']);
        }catch(\Exception $e){
            return response()->json(['success' => 0, 'message' => 'Something went wrong','error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubLocation $sub_location)
    {
        $locations = Location::all();
        return view('admin.pages.sub_locations.edit',compact('sub_location','locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required','max:255',Rule::unique('locations')->ignore($id)],
            'location' => 'required|exists:locations,id'
        ]);
        if($validated){
            $slug = $this->services->slugify($request->name);
            try{
            $location = SubLocation::find($request->id);

            $location->name = $request->name;
            $location->location_id = $request->location;
            $location->slug = $slug;
            $location->save();
            return response()->json(['success' => 1, 'message' => 'Sub Location updated successfully']);
            }catch(\Exception $e){
                return response()->json(['success' => 0, 'message' => 'Something went wrong','error' => $e->getMessage()]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $location = SubLocation::find($id);
            if(!$location){
                return response()->json(['success' => 0, 'message' => 'Sub Location not found']);
            }
            $location->delete();
            return response()->json(['success' => 1, 'message' => 'Sub Location deleted successfully']);
        }catch(\Exception $e){
            return response()->json(['success' => 0, 'message' => 'Something went wrong']);
        }
    }
}
