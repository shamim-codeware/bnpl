<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $title = "Product Packages";
        $description = "Manage product packages";

        $query = Package::with('users')->orderBy('id', 'DESC');

        if ($request->keyword) {
            $query->where('name', 'like', "%{$request->keyword}%");
        }

        $packages = $query->paginate(30);

        return view('pages.settings.package.index', compact('title', 'description', 'packages'));
    }

    public function create()
    {
        $title = "Add Product Package";
        $description = "Create new product package";
        return view('pages.settings.package.create', compact('title', 'description'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:packages,name',
        ]);

        $package = new Package();
        $data = $request->all();
        $data['created_by'] = Auth::id();
        $package->fill($data)->save();

        return redirect()->route('package.index')->with('success', 'Success! Create Product Package');
    }

    public function edit($id)
    {
        $title = "Edit Product Package";
        $description = "Update product package";
        $package = Package::findOrFail($id);
        return view('pages.settings.package.edit', compact('title', 'description', 'package'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:packages,name,' . $id,
        ]);

        $package = Package::findOrFail($id);
        $package->fill($request->all())->save();

        return redirect()->route('package.index')->with('success', 'Success! Update Product Package');
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();
        return redirect()->route('package.index')->with('success', 'Package deleted successfully!');
    }
}
