<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Zone;
use App\Models\ShowRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Enquiry";
        $description = "Some description for the page";
        // Query
        $query = Zone::query();
        // Keyword
        if($request->keyword){
            $query->where('name', 'like', "%$request->keyword%");
        }
        $zones = $query->orderBy('id','ASC')->get();

        return view('pages.settings.zone.index', compact('title', 'description','zones'));
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

        $zones = new Zone();
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $zones->fill($data)->save();

        return  redirect()->back()->with('success', 'Success! Create Zone ');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $title = "Zone Edit";
        $description = "Some description for the page";

        $zone = Zone::findOrFail($id);

        return view('pages.settings.zone.edit', compact('title', 'description','zone'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $zone = Zone::findOrFail($id);

        $zone->fill($request->all())->save();
       
        return  redirect('zones')->with('success', 'Success! Update Zone');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function status($id){
        $zone = Zone::findOrFail($id);
      if($zone->status == 1){
        $zone->status = 0;
       
      }else{
        $zone->status = 1;
      }
      $zone->save();

      return  redirect('zones')->with('success', 'Success! Status Update');
    }


  
}
