<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SubCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;

class SubCategoriesController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(SubCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.pages.sub_categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $category = Category::all();
        return view('admin.pages.sub_category.create',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'name' => 'required|unique:sub_categories|max:255',
        ]);
        if($validated){
            try{
            $sub_category = new SubCategory();
            $sub_category->name = $request->name;
            $sub_category->category_id = $request->category;
            $sub_category->save();
            return response()->json(['success' => 1, 'message' => 'SubSubCategory added successfully']);
            }catch(\Exception $e){
                return response()->json(['success' => 0, 'message' => 'Something went wrong']);
            }
        }
       
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $category,$id)
    {
        //
        $sub_category = SubCategory::find($id);
        return view('admin.pages.countries.edit',compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCategory $category)
    {
        //
        $validated = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:255',
        ]);
        if($validated){
            try{
            $sub_category = SubCategory::find($request->id);
            $sub_category->name = $request->name;
            $sub_category->code = $request->code;
            $sub_category->phone_code = $request->phone_code;
            $sub_category->save();
            return response()->json(['success' => 1, 'message' => 'Country updated successfully']);
            }catch(\Exception $e){
                return response()->json(['success' => 0, 'message' => 'Something went wrong']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $category)
    {
        //
    }
}
