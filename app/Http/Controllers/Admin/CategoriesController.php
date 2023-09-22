<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\GeneralServices;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    protected $services;
    public function __construct()
    {
        $this->services = new GeneralServices();
    }
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
        return view('admin.pages.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);

        $slug = $this->services->slugify($request->name);
        if ($validated) {
            try {
                $category = new Category();
                $category->name = $request->name;
                $category->slug = $slug;
                $category->save();
                return response()->json(['success' => 1, 'message' => 'Category added successfully']);
            } catch (\Exception $e) {
                $message = $e->getMessage();
                return response()->json(['success' => 0, 'message' => 'Something went wrong', 'error' => $message]);
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
    public function edit(Category $category)
    {
        //
        // dd($category);
        // $category = Category::find($id);
        return view('admin.pages.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
       
        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);
        $slug = $this->services->slugify($request->name);
        if ($validated) {
            try {
                $category->name = $request->name;
                $category->slug = $slug;
                $category->save();
                return response()->json(['success' => 1, 'message' => 'Category updated successfully']);
            } catch (\Exception $e) {
                return response()->json(['success' => 0, 'message' => 'Something went wrong']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            if (!$category) {
                return response()->json(['success' => 0, 'message' => 'Category not found']);
            }
            $category->delete();
            return response()->json(['success' => 1, 'message' => 'Category deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'message' => 'Something went wrong']);
        }
    }
}
