<?php

namespace App\Http\Controllers;

use App\Models\EnquiryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class EnquiryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Enquiry Type";
        $description = "Some description for the page";
        // Query
        $query = EnquiryType::with('users');
        // Keyword
        if($request->keyword){
            $query->where('name', 'like', "%$request->keyword%");
        } 
        $types = $query->orderBy('id','DESC')->paginate(30);

        return view('pages.settings.enqu_type.index', compact('title', 'description','types'));
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
       // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255|unique:enquiry_types,name',
        ]);

        $enquerytype = new EnquiryType();
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $enquerytype->fill($data)->save();
        return  redirect()->back()->with('success', 'Success! Create Enquiry Type');
    }

    /**
     * Display the specified resource.
     */
    public function show(EnquiryType $enquiryType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EnquiryType $enquiryType)
    {
        $title = "Enquiry Type";
        $description = "Some description for the page";
        return view('pages.settings.enqu_type.edit', compact('title', 'description','enquiryType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EnquiryType $enquiryType)
    {
        $enquiryType->fill($request->all())->save();
        return  redirect('enquiry-type')->with('success', 'Success! Update Enquiry Type');
      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EnquiryType $enquiryType)
    {
        //
    }

    public function status($id){
        $enqutype = EnquiryType::findOrFail($id);
      if($enqutype->status == 1){
        $enqutype->status = 0;
       
      }else{
        $enqutype->status = 1;
      }
      $enqutype->save();

      return  redirect()->back()->with('success', 'Success! Enquiry Type Status');
    }
}
