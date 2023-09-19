<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CountriesDataTable;
use App\Models\Countries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CountriesDataTable $dataTable)
    {
        return $dataTable->render('admin.pages.countries.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.pages.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'name' => 'required|unique:countries|max:255',
            'code' => 'required|unique:countries|max:255',
        ]);
        if($validated){
            try{
            $country = new Countries();
            $country->name = $request->name;
            $country->code = $request->code;
            $country->phone_code = $request->phone_code;
            $country->save();
            return response()->json(['success' => 1, 'message' => 'Country added successfully']);
            }catch(\Exception $e){
                return response()->json(['success' => 0, 'message' => 'Something went wrong']);
            }
        }
       
    }

    /**
     * Display the specified resource.
     */
    public function show(Countries $countries)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Countries $countries,$id)
    {
        //
        $country = Countries::find($id);
        return view('admin.pages.countries.edit',compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Countries $countries)
    {
        //
        $validated = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:255',
        ]);
        if($validated){
            try{
            $country = Countries::find($request->id);
            if(!$country){
                return response()->json(['success' => 0, 'message' => 'Country not found']);
            }
            $country->name = $request->name;
            $country->code = $request->code;
            $country->phone_code = $request->phone_code;
            $country->save();
            return response()->json(['success' => 1, 'message' => 'Country updated successfully']);
            }catch(\Exception $e){
                return response()->json(['success' => 0, 'message' => 'Something went wrong']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        try{
            $country = Countries::find($request->id);
            if(!$country){
                return response()->json(['success' => 0, 'message' => 'Country not found']);
            }
            $country->delete();
            return response()->json(['success' => 1, 'message' => 'Country deleted successfully']);
            }catch(\Exception $e){
                return response()->json(['success' => 0, 'message' => 'Something went wrong']);
            }
    }
}
