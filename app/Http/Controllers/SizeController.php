<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Auth;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Product Size ";
        $description = "Some description for the page";
        $types = ProductType::latest()->get();
        $query = Size::with(['users','group'])->orderBy('id','DESC');
        // Keyword
        if ($request->keyword) {
            $query->where('name', 'like', "%$request->keyword%");
        }
        $brands = $query->paginate(30);

        return view('pages.settings.size.index', compact('title', "types",'description', 'brands'));
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
            'name' => 'required|string|max:255|unique:sizes,name',
        ]);

        $productbrand = new Size();
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $productbrand->fill($data)->save();
        return  redirect()->back()->with('success', 'Success! Create Product Size ');
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
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
        $sizes = Size::findOrFail($id);
        $types = ProductType::latest()->get();
        return view('pages.settings.size.edit', compact('title','types' ,'description', 'sizes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $productbrand = Size::findOrFail($id);
        $productbrand->fill($request->all())->save();
        return  redirect('sizes')->with('success', 'Success! Update Product Brand');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        //
    }
}
