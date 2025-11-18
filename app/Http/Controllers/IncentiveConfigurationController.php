<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\IncentiveConfiguration;

class IncentiveConfigurationController extends Controller
{
    public function index(Request $request)
    {
        $title = "Incentive Configuration";
        $description = "Manage product incentives";

        $categories = ProductCategory::orderBy('name', 'ASC')->get();
        $products = Product::orderBy('product_model', 'ASC')->get();

        $query = IncentiveConfiguration::with(['creator']);

        // Filter by type
        if ($request->type) {
            $query->where('type', $request->type);
        }

        // Search
        if ($request->keyword) {
            $query->where('name', 'like', "%{$request->keyword}%");
        }

        $incentives = $query->orderBy('id', 'DESC')->paginate(30);

        return view('pages.settings.incentive-config.index', compact(
            'title',
            'description',
            'incentives',
            'categories',
            'products'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:category,model',
            'reference_id' => 'required|integer',
            'incentive_amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Get the name based on type
            if ($request->type == 'category') {
                $category = ProductCategory::findOrFail($request->reference_id);
                $name = $category->name;

                // Check if already exists
                $exists = IncentiveConfiguration::where('type', 'category')
                    ->where('reference_id', $request->reference_id)
                    ->exists();

                if ($exists) {
                    return redirect()->back()->with('error', 'Incentive for this category already exists!');
                }
            } else {
                $product = Product::findOrFail($request->reference_id);
                $name = $product->product_model;

                // Check if already exists
                $exists = IncentiveConfiguration::where('type', 'model')
                    ->where('reference_id', $request->reference_id)
                    ->exists();

                if ($exists) {
                    return redirect()->back()->with('error', 'Incentive for this model already exists!');
                }
            }

            IncentiveConfiguration::create([
                'type' => $request->type,
                'reference_id' => $request->reference_id,
                'name' => $name,
                'incentive_amount' => $request->incentive_amount,
                'is_active' => true,
                'created_by' => Auth::id(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Incentive configuration added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to add incentive: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $title = "Edit Incentive Configuration";
        $description = "Update incentive configuration";

        $incentive = IncentiveConfiguration::findOrFail($id);
        $categories = ProductCategory::orderBy('name', 'ASC')->get();
        $products = Product::orderBy('product_model', 'ASC')->get();

        return view('pages.settings.incentive-config.edit', compact(
            'title',
            'description',
            'incentive',
            'categories',
            'products'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'incentive_amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $incentive = IncentiveConfiguration::findOrFail($id);
            $incentive->update([
                'incentive_amount' => $request->incentive_amount,
            ]);

            DB::commit();
            return redirect()->route('incentive-configuration.index')
                ->with('success', 'Incentive updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        try {
            $incentive = IncentiveConfiguration::findOrFail($id);
            $incentive->is_active = !$incentive->is_active;
            $incentive->save();

            return redirect()->back()->with('success', 'Status updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update status: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $incentive = IncentiveConfiguration::findOrFail($id);
            $incentive->delete();

            return redirect()->back()->with('success', 'Incentive deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete: ' . $e->getMessage());
        }
    }
}
