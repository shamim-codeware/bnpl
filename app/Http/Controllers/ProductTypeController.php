<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Http\Request;
use Auth;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Product Type";
        $description = "Some description for the page";
  
        $query = ProductType::with('users')->orderBy('id','DESC');
        
        // Keyword
        if ($request->keyword) {
            $query->where('name', 'like', "%$request->keyword%");
        }
        $producttypes = $query->paginate(30);

        return view('pages.settings.product_type.index', compact('title', 'description', 'producttypes'));
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
            'name' => 'required|string|max:255|unique:enquiry_types,name',
        ]);

        $enquerytype = new ProductType();
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $enquerytype->fill($data)->save();
        return  redirect()->back()->with('success', 'Success! Create Product Type');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductType $productType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductType $productType,$id)
    {
        $title = "Enquiry Type";
        $description = "Some description for the page";
        $productType = ProductType::findOrFail($id);
        return view('pages.settings.product_type.edit', compact('title', 'description', 'productType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductType $productType,$id)
    {
         $productType = ProductType::findOrFail($id);
        $productType->fill($request->all())->save();
        return  redirect('group')->with('success', 'Success! Update Product Group');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductType $productType)
    {
        //
    }

    public function QueryType(Request $request)
    {
       
        $producttype = ProductType::orderBy('id','DESC')->get();

        return $producttype;

    }
}
