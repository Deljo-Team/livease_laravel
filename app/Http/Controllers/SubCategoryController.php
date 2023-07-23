<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubCategoryRequest;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index(SubCategoryRequest $request)
    {
        $categories = SubCategory::where('category_id', $request->category_id)->get();
        return response()->json([
            'Success' => true,
            'Message' => 'Category List',
            'Title' => 'Success',
            'Data' => ['categories'=>$categories]
        ], 200);
    }
}
