<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\LocationsDataTable;
use App\Models\Countries;
use App\Models\Location;
use App\Services\GeneralServices;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LocationController extends Controller
{
    protected $services;
    public function __construct()
    {
        $this->services = new GeneralServices();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(LocationsDataTable $dataTable)
    {
        return $dataTable->render('admin.pages.locations.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $countries = Countries::all();
        return view('admin.pages.locations.create',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'name' => 'required|unique:locations|max:255',
            'country' => 'required|exists:countries,id'
        ]);
        try{
        
        $location = new Location();
        $location->name = $request->name;
        $location->country_id = $request->country;
        $location->slug = $this->services->slugify($request->name);
        $location->save();
        return response()->json(['success' => 1, 'message' => 'Location added successfully']);
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
    public function edit(Location $location)
    {
        $countries = Countries::all();
        return view('admin.pages.locations.edit',compact('location','countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => ['required','max:255',Rule::unique('locations')->ignore($id)],
            'country' => 'required|exists:countries,id'
        ]);
        if($validated){
            $slug = $this->services->slugify($request->name);
            try{
            $location = Location::find($request->id);

            $location->name = $request->name;
            $location->country_id = $request->country;
            $location->slug = $slug;
            $location->save();
            return response()->json(['success' => 1, 'message' => 'Location updated successfully']);
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
            $location = Location::find($id);
            if(!$location){
                return response()->json(['success' => 0, 'message' => 'Location not found']);
            }
            $location->delete();
            return response()->json(['success' => 1, 'message' => 'Location deleted successfully']);
        }catch(\Exception $e){
            return response()->json(['success' => 0, 'message' => 'Something went wrong']);
        }
    }
}
