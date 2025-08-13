<?php

namespace App\Http\Controllers;

use App\Models\EnquirySource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class EnquirySourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $title = "Enquiry Source";
        $description = "Some description for the page";
        // Query
        $enquiry_parents = EnquirySource::orderBy('id','DESC')->where('status',1)->where('parent_id',0)->get();
        $query = EnquirySource::with(['users','parents']);
        // Keyword
        if($request->keyword){
            $query->where('name', 'like', "%$request->keyword%");
        }
        $enquiry_sources = $query->orderBy('id','DESC')->paginate(30);
        
        return view('pages.settings.enqu_source.index', compact('title', 'description','enquiry_sources','enquiry_parents'));
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
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $source = new EnquirySource();
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $source->fill($data)->save();

       return  redirect()->back()->with('success', 'Success! Create Enquiry Source');
    }

    /**
     * Display the specified resource.
     */
    public function show(EnquirySource $enquirySource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = "Enquiry Source";
        $description = "Some description for the page";
        $enquirySource = EnquirySource::with(['parents'])->findOrFail($id);

        $enquiryparents = EnquirySource::orderBy('id','DESC')->where('id','!=',$enquirySource->parent_id)->where('parent_id',0)->where('status',1)->get();
        return view('pages.settings.enqu_source.edit', compact('title', 'description','enquirySource','enquiryparents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EnquirySource $enquirySource)
    {
        $enquirySource->fill($request->all())->save();

       // return redirect('enquiry-source');

        return redirect('enquiry-source')->with('success', 'Success! Update Enquiry Source');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EnquirySource $enquirySource)
    {
        //
    }

    public function status($id){
        $enqusource = EnquirySource::findOrFail($id);
      if($enqusource->status == 1){
        $enqusource->status = 0;

      }else{
        $enqusource->status = 1;
      }
      $enqusource->save();

      return  redirect()->back()->with('success', 'Success! Enquiry Source Status');
    }
}
