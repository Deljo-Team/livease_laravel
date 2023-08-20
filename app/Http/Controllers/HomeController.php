<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $customerCount = User::customers()->count();
        $vendorCount = User::vendors()->count();
        // dd($customerCount, $vendorCount);
        return view('home', compact('customerCount', 'vendorCount'));
    }
}
