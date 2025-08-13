<?php

namespace App\Http\Controllers;

use App\Models\DownPaymentSetting;
use Illuminate\Http\Request;

class DownPaymentSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Down Payment Settings";
        $description = "Some description for the page";
        $downpayment = DownPaymentSetting::latest()->get();
        return view('pages.settings.down-payment-settings.index', compact('title', 'description', 'downpayment'));
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
        $downpayment = new DownPaymentSetting;
        $downpayment->fill($request->all())->save();
        return  redirect()->back()->with('success', 'Success! Down Payment Save');

    }

    /**
     * Display the specified resource.
     */
    public function show(DownPaymentSetting $downPaymentSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DownPaymentSetting $downPaymentSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id){
        $DownPaymentSetting = DownPaymentSetting::findOrFail($id);
        $DownPaymentSetting->fill($request->all())->save();
        return  redirect()->back()->with('success', 'Success! Down Payment Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DownPaymentSetting $downPaymentSetting)
    {
        //
    }
}
