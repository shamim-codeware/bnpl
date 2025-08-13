<?php

namespace App\Http\Controllers;

use App\Models\FollowUpMethod;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator; 

class FollowUpMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Follow Up Method";
        $description = "Some description for the page";
        // Query
        $query = FollowUpMethod::with('users');
        // Keyword
        if($request->keyword){
            $query->where('name', 'like', "%$request->keyword%");
        }
        $types = $query->orderBy('id','DESC')->paginate(30);
 
        return view('pages.settings.follow-up-method.index', compact('title', 'description','types'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
           
        ]);

        $enquerytype = new FollowUpMethod();
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $enquerytype->fill($data)->save();

        return  redirect()->back()->with('success', 'Success! Create Follow-Up Method');
    }

    /**
     * Display the specified resource.
     */
    public function show(FollowUpMethod $followUpMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FollowUpMethod $followUpMethod)
    {
        $title = "Follow Up Method";
        $description = "Some description for the page";
        return view('pages.settings.follow-up-method.edit', compact('title', 'description','followUpMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FollowUpMethod $followUpMethod)
    {
        $followUpMethod->fill($request->all())->save();
        return  redirect('follow-up-method')->with('success', 'Success! Update Follow-Up Method');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FollowUpMethod $followUpMethod)
    {
        //
    }

    public function status($id){
        $enqutype = FollowUpMethod::findOrFail($id);
       
      if($enqutype->status == 1){
        $enqutype->status = 0;
       
      }else{
        $enqutype->status = 1;
      }
      $enqutype->save();

      return  redirect()->back()->with('success', 'Success! Follow Up Method Status');
    }
}
