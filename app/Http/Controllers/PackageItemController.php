<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Product;
use App\Models\PackageItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PackageItemController extends Controller
{
    public function index(Request $request)
    {
        $title = "Package Products";
        $description = "Manage package products";

        $query = PackageItem::with(['package', 'product', 'users','product.types','product.categories'])
            ->orderBy('id', 'DESC');

        // Optional: filter by package
        if ($request->filled('package_id')) {
            $query->where('package_id', $request->package_id);
        }

        $packageItems = $query->paginate(30);
        $packages = Package::orderBy('name')->get();

        return view('pages.settings.package-product.index', compact('title', 'description', 'packageItems', 'packages'));
    }

    public function create()
    {
        $title = "Add Package Product";
        $description = "Assign a product to a package";
        $packages = Package::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('pages.settings.package-product.create', compact('title', 'description', 'packages', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'product_id' => 'required|array|min:1',
            'product_id.*' => 'exists:products,id|distinct',
        ]);

        $packageId = $request->package_id;
        $productIds = $request->product_id;
        $createdBy = Auth::id();

        $existingCombinations = PackageItem::whereIn('product_id', $productIds)
            ->where('package_id', $packageId)
            ->pluck('product_id')
            ->toArray();

        $newProductIds = array_diff($productIds, $existingCombinations);

        if (empty($newProductIds)) {
            return back()->withErrors(['product_id' => 'All selected products are already added to this package.']);
        }

        foreach ($newProductIds as $productId) {
            PackageItem::create([
                'package_id' => $packageId,
                'product_id' => $productId,
                'created_by' => $createdBy,
            ]);
        }

        return redirect()->route('package-product.index')->with('success', 'Product(s) added to package successfully!');
    }

    public function edit($id)
    {
        $title = "Edit Package Product";
        $description = "Update package product";
        $packageItem = PackageItem::findOrFail($id);
        $packages = Package::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('pages.settings.package-product.edit', compact('title', 'description', 'packageItem', 'packages', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'product_id' => 'required|exists:products,id',
        ]);

        // Prevent duplicate with other rows
        $exists = PackageItem::where('package_id', $request->package_id)
            ->where('product_id', $request->product_id)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'product_id' => 'This product is already in the selected package.'
            ])->withInput();
        }

        $packageItem = PackageItem::findOrFail($id);
        $packageItem->update($request->only(['package_id', 'product_id']));

        return redirect()->route('package-product.index')->with('success', 'Package product updated successfully!');
    }

    public function destroy($id)
    {
        $packageItem = PackageItem::findOrFail($id);
        $packageItem->delete();

        return redirect()->route('package-product.index')->with('success', 'Package Product deleted successfully!');
    }


    public function getPackageItems($id)
    {
        $package = Package::with('items.product','items.product.types', 'items.product.categories')->findOrFail($id);

        return response()->json([
            'success' => true,
            'package' => $package->name,
            'items' => $package->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'product' => [
                        'id' => $item->product->id,
                        'name' => $item->product->name,
                        'product_model' => $item->product->product_model,
                        'product_group' => $item->product->types?->name,
                        'product_category' => $item->product->categories?->name,
                        'cash_price' => $item->product->hire_price ?? 0,
                    ]
                ];
            })
        ]);
    }
}
