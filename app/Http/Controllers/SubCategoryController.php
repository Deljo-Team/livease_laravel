<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index(SubCategoryRequest $request)
    {
        $categories = Category::select('id','name')->whereIn('id', $request->categories)->with('sub_categories')->get();
        return response()->json([
            'Success' => true,
            'Message' => 'Sub Category List',
            'Title' => 'Success',
            'Data' => ['categories'=>$categories]
        ], 200);
    }
}
