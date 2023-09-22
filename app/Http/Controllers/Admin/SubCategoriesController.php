<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SubCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Services\GeneralServices;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubCategoriesController extends Controller
{
    protected $services;
    public function __construct()
    {
        $this->services = new GeneralServices();
    }
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
        $categories = Category::all();
        return view('admin.pages.sub_categories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'name' => 'required|max:255|unique:sub_categories,name',
            'category' => 'required|exists:categories,id'
        ]);
        if($validated){
            $slug = $this->services->slugify($request->name);
            try{
            $sub_category = new SubCategory();
            $sub_category->name = $request->name;
            $sub_category->category_id = $request->category;
            $sub_category->slug = $slug;
            $sub_category->save();
            return response()->json(['success' => 1, 'message' => 'SubSubCategory added successfully']);
            }catch(\Exception $e){

                return response()->json(['success' => 0, 'message' => 'Something went wrong','error' => $e->getMessage()]);
            }
        }
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $category,$id)
    {
        //
        $sub_category = SubCategory::find($id);
        $categories = Category::all();
        return view('admin.pages.sub_categories.edit',compact('sub_category','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        $validated = $request->validate([
            'name' => ['required','max:255',Rule::unique('sub_categories')->ignore($request->id)],
            'category' => 'required|exists:categories,id'
        ]);
        if($validated){
            $slug = $this->services->slugify($request->name);
            try{
            $sub_category = SubCategory::find($request->id);

            $sub_category->name = $request->name;
            $sub_category->category_id = $request->category;
            $sub_category->slug = $slug;
            $sub_category->save();
            return response()->json(['success' => 1, 'message' => 'SubCategory updated successfully']);
            }catch(\Exception $e){
                return response()->json(['success' => 0, 'message' => 'Something went wrong','error' => $e->getMessage()]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $id)
    {
        try{
            $sub_category = SubCategory::find($id);
            if(!$sub_category){
                return response()->json(['success' => 0, 'message' => 'Sub Category not found']);
            }
            $sub_category->delete();
            return response()->json(['success' => 1, 'message' => 'Sub Category deleted successfully']);
        }catch(\Exception $e){
            return response()->json(['success' => 0, 'message' => 'Something went wrong']);
        }
    }
}
