<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(CategoriesDataTable $dataTable)
    {
        return $dataTable->render('admin.pages.categories.index');
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
            $country = new Category();
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
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category,$id)
    {
        //
        $country = Category::find($id);
        return view('admin.pages.countries.edit',compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
        $validated = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:255',
        ]);
        if($validated){
            try{
            $country = Category::find($request->id);
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
    public function destroy(Category $category)
    {
        //
    }
}
