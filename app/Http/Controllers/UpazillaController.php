<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upazila;
use DB;

class UpazillaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Customer Type";
        $description = "Some description for the page";
        // Query
        $query = Upazila::with(['district']);
        // Keyword
        if($request->keyword){
            $query->where('name', 'like', "%$request->keyword%");
        }
        if($request->district_id){
            $query->where('district_id', $request->district_id);
        }
        $types = $query->orderBy('id','DESC')->paginate(40);
        $districts = DB::table('districts')->orderBy('id','DESC')->where('status',1)->get();
       
        return view('pages.settings.upazila.index', compact('title', 'description','districts','types'));
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
        $Upazila = new Upazila;

        $Upazila->fill($request->all())->save();

        return  redirect()->back()->with('success', 'Success! Create Upazila/Thana');
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
        $title = "Upazila Create";
        $description = "Some description for the page";
        $upazilas = Upazila::where('id',$id)->with(['district'])->orderBy('id','DESC')->first();
      // dd($showroom);
        $districts = DB::table('districts')->orderBy('id','DESC')->get();

        return view('pages.settings.upazila.edit', compact('title', 'description','upazilas','districts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $upazila = Upazila::findOrFail($id);
        $upazila->fill($request->all())->save();
        return  redirect('upazila')->with('success', 'Success! Update Upazila');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
