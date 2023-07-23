<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'Success' => true,
            'Message' => 'Category List',
            'Title' => 'Success',
            'Data' => ['categories'=>$categories]
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $countries)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $countries)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $countries)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $countries)
    {
        //
    }
}
