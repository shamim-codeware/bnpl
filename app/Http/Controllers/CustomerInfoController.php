<?php

namespace App\Http\Controllers;

use App\Models\CustomerInfo;
use Illuminate\Http\Request;
use DB;

class CustomerInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Customer Type";
        $description = "Some description for the page";

        $districts = DB::table('districts')->orderBy('id', 'DESC')->where('status', 1)->get();
        return view('installment.hire_purchase.application',compact("title","description","districts"));
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
        
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerInfo $customerInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerInfo $customerInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerInfo $customerInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerInfo $customerInfo)
    {
        //
    }
}
