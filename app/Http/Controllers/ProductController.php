<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Auth;
use App\Models\ProductType;
use App\Models\Brand;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Product ";
        $description = "Some description for the page";

         $category = ProductCategory::orderBy('id', 'DESC')->get();
        $types = ProductType::orderBy('id', 'DESC')->get();
        $query = Product::with(['users', 'categories', 'types'])->orderBy('id','DESC');

        // Filter by type
        $query->when($request->type_id, function ($q) use ($request) {
            return $q->where('type_id', $request->type_id);
        });
        //filter by category
        $query->when($request->category_id, function ($q) use ($request) {
            return $q->where('category_id', $request->category_id);
        });

        // Keyword
        if ($request->keyword) {
            $query->where('name', 'like', "%$request->keyword%")
            ->orWhere('product_model', 'like', "%$request->keyword%");
        }

        $products = $query->paginate(50);

        return view('pages.settings.product.index', compact('title', 'description', 'products','category','types'));
    }

    public function GetPrice(Request $request){

        $product = Product::findOrFail($request->id);

        $data['price'] = $product->hire_price;
        $data['size']  = $product->size;
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Product ";
        $description = "Some description for the page";

        $brands = Brand::latest()->get();
        return view('pages.settings.product.create', compact('title', 'brands','description'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        // ]);

        $productcategory = new Product();
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $productcategory->fill($data)->save();
        return  redirect()->back()->with('success', 'Success! Create Product');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = "Product Category";
        $description = "Some description for the page";
        $types = ProductType::orderBy('id', 'DESC')->get();
        $product = Product::with(['types', 'categories','brands'])->findOrFail($id);

        $category = ProductCategory::where('type_id',$product->type_id)->get();

        $brands = Brand::latest()->get();
        return view('pages.settings.product.edit', compact('title', 'brands','description', 'product', 'types',"category"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $product = Product::findOrFail($id);
        $product->fill($request->all())->save();
        return  redirect('product')->with('success', 'Success! Update Product');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function status($id){
        $product = Product::findOrFail($id);
        if ($product->status == "publish") {
            $product->status = "draft";
        } else {
            $product->status = "publish";
        }
        $product->save();
        return redirect()->back()->with('success', 'Success! Update Product');
    }

    public function QueryProduct(Request $request){

        $producttype = Product::where('type_id', $request->type)->where('category_id', $request->category)->orderBy('id', 'DESC')->get();

        return $producttype;
    }
}
