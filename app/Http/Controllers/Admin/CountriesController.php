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
    public function show(Countries $countries)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Countries $countries)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Countries $countries)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Countries $countries)
    {
        //
    }
}
