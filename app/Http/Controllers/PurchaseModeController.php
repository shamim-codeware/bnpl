<?php

namespace App\Http\Controllers;

use App\Models\PurchaseMode;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator; 

class PurchaseModeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Purchase mode Type";
        $description = "Some description for the page";
        // Query
        $query = PurchaseMode::with('users');
        // Keyword
        if($request->keyword){
            $query->where('name', 'like', "%$request->keyword%");
        }
        $types = $query->orderBy('id','DESC')->paginate(30);
       // dd($types);
        return view('pages.settings.purchase_mode.index', compact('title', 'description','types'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
           
        ]);

        $enquerytype = new PurchaseMode();
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $enquerytype->fill($data)->save();

        return  redirect()->back()->with('success', 'Success! Create Purchase Mode');
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseMode $purchaseMode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseMode $purchaseMode)
    {
        $title = "Purchase mode";
        $description = "Some description for the page";
        return view('pages.settings.purchase_mode.edit', compact('title', 'description','purchaseMode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseMode $purchaseMode)
    {
        $purchaseMode->fill($request->all())->save();
      
        return  redirect('purchase-mode')->with('success', 'Success! Update Purchase Mode');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseMode $purchaseMode)
    {
        //
    }


    public function status($id){
        $enqutype = PurchaseMode::findOrFail($id);
      if($enqutype->status == 1){
        $enqutype->status = 0;
       
      }else{
        $enqutype->status = 1;
      }
      $enqutype->save();

      return  redirect()->back()->with('success', 'Success! Purchase Mode Status ');
    }
}
