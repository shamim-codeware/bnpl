<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ProductType;
use App\Models\Brand;
use App\Models\ProductCategory;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductExport;

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
        $query = Product::with(['users', 'categories', 'types', 'updater'])->orderBy('id','DESC');

        // Filter by type
        $query->when($request->type_id, function ($q) use ($request) {
            return $q->where('type_id', $request->type_id);
        });
        //filter by category
        $query->when($request->category_id, function ($q) use ($request) {
            return $q->where('category_id', $request->category_id);
        });

        // Date range
        $query->when($request->filled('from_date'), function ($q) use ($request) {
            $q->whereDate('created_at', '>=', Carbon::parse($request->from_date)->format('Y-m-d'));
        });
        $query->when($request->filled('to_date'), function ($q) use ($request) {
            $q->whereDate('created_at', '<=', Carbon::parse($request->to_date)->format('Y-m-d'));
        });

        // Keyword
        $query->when($request->filled('keyword'), function ($q) use ($request) {
            $keyword = $request->keyword;
            $q->where(function ($subQuery) use ($keyword) {
                $subQuery->where('name', 'like', "%{$keyword}%")
                    ->orWhere('product_model', 'like', "%{$keyword}%");
            });
        });

        $products = $query->paginate(50)->appends($request->query());

        return view('pages.settings.product.index', compact('title', 'description', 'products','category','types'));
    }

    public function export(Request $request)
    {
        $query = Product::with(['users', 'categories', 'types', 'updater'])->orderBy('id', 'DESC');

        $query->when($request->filled('type_id'), function ($q) use ($request) {
            $q->where('type_id', $request->type_id);
        });

        $query->when($request->filled('category_id'), function ($q) use ($request) {
            $q->where('category_id', $request->category_id);
        });

        $query->when($request->filled('from_date'), function ($q) use ($request) {
            $q->whereDate('created_at', '>=', Carbon::parse($request->from_date)->format('Y-m-d'));
        });

        $query->when($request->filled('to_date'), function ($q) use ($request) {
            $q->whereDate('created_at', '<=', Carbon::parse($request->to_date)->format('Y-m-d'));
        });

        $query->when($request->filled('keyword'), function ($q) use ($request) {
            $keyword = $request->keyword;
            $q->where(function ($subQuery) use ($keyword) {
                $subQuery->where('name', 'like', "%{$keyword}%")
                    ->orWhere('product_model', 'like', "%{$keyword}%");
            });
        });

        $products = $query->get();
        $filename = 'product-report-' . now()->format('Y-m-d_His') . '.xlsx';

        return Excel::download(new ProductExport($products), $filename);
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
        $data['updated_by'] = Auth::user()->id;
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

        // Capture previous data
        $previousData = $product->toArray();

        // Update the product
        $product->fill($request->all());
        $product->updated_by = Auth::id();
        $product->save();

        // Capture current data
        $currentData = $product->fresh()->toArray();

        // Determine changed fields, ignore automatic timestamp changes
        $ignoreFields = ['created_at', 'updated_at'];
        $changedFields = [];
        foreach ($currentData as $key => $value) {
            if (in_array($key, $ignoreFields, true)) {
                continue;
            }

            if (array_key_exists($key, $previousData) && $previousData[$key] != $value) {
                $changedFields[$key] = [
                    'old' => $previousData[$key],
                    'new' => $value
                ];
            }
        }

        // Log the audit if there were changes
        if (!empty($changedFields)) {
            \App\Models\ProductAudit::create([
                'product_id' => $product->id,
                'updated_by' => Auth::id(),
                'previous_data' => $previousData,
                'current_data' => $currentData,
                'changed_fields' => $changedFields,
                'updated_at' => now(),
            ]);
        }

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
        $product->updated_by = Auth::id();
        $product->save();
        return redirect()->back()->with('success', 'Success! Update Product');
    }

    public function QueryProduct(Request $request){

        $producttype = Product::where('type_id', $request->type)->where('category_id', $request->category)->orderBy('id', 'DESC')->get();

        return $producttype;
    }
}
