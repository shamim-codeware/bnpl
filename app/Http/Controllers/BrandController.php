<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Auth;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Product Brand";
        $description = "Some description for the page";
  
        $query = Brand::with('users')->orderBy('id','DESC');
        
        // Keyword
        if ($request->keyword) {
            $query->where('name', 'like', "%$request->keyword%");
        }
        $brands = $query->paginate(30);

        return view('pages.settings.brand.index', compact('title', 'description', 'brands'));
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
            'name' => 'required|string|max:255|unique:brands,name',
        ]);

        $productbrand = new Brand();
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $productbrand->fill($data)->save();
        return  redirect()->back()->with('success', 'Success! Create Product Brand ');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = "Enquiry Type";
        $description = "Some description for the page";
        $productbrand = Brand::findOrFail($id);
        return view('pages.settings.brand.edit', compact('title', 'description', 'productbrand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        
        $productbrand = Brand::findOrFail($id);
        $productbrand->fill($request->all())->save();
        return  redirect('brand')->with('success', 'Success! Update Product Brand');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        //
    }
}
