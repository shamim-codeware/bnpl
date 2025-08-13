<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Models\ProductType;
use App\Models\Size;
use Auth;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Enquiry Source";
        $description = "Some description for the page";
        $types = ProductType::orderBy('id','DESC')->get();
        // Query
        $query = ProductCategory::with(['types', 'users']);
        // Keyword
        if ($request->keyword) {
            $query->where('name', 'like', "%$request->keyword%");
        }
        $productcategories = $query->orderBy('id', 'DESC')->paginate(30);
        return view('pages.settings.category.index', compact('title', 'description','types','productcategories'));
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

        $productcategory = new ProductCategory();
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $productcategory->fill($data)->save();
        return  redirect()->back()->with('success', 'Success! Create Product Category');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory,$id)
    {
        $title = "Product Category";
        $description = "Some description for the page";
        $types = ProductType::orderBy('id', 'DESC')->get();
        $productcategory = ProductCategory::with('types')->findOrFail($id);
        return view('pages.settings.category.edit', compact('title', 'description', 'productcategory', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory,$id)
    {

        $productCategory = ProductCategory::findOrFail($id);
        $productCategory->fill($request->all())->save();
        return  redirect('category')->with('success', 'Success! Update Product Category');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        //
    }


    public function QueryCategory(Request $request)
    {

        $producttype = ProductCategory::where('type_id',$request->type)->orderBy('id', 'DESC')->get();

        $product_size = Size::where('gourp_id',$request->type)->latest()->get();

        $data =  [$producttype,$product_size];

        return $data;
    }
}
