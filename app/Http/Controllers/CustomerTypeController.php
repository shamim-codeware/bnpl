<?php

namespace App\Http\Controllers;

use App\Models\CustomerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; 
class CustomerTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Customer Type";
        $description = "Some description for the page";
        // Query
        $query = CustomerType::with('users');
        // Keyword
        if($request->keyword){
            $query->where('name', 'like', "%$request->keyword%");
        }
        $types = $query->orderBy('id','DESC')->paginate(30);
       
        return view('pages.settings.cus_type.index', compact('title', 'description','types'));
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

        $enquerytype = new CustomerType();
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $enquerytype->fill($data)->save();
        return  redirect()->back()->with('success', 'Success! Create Customer');
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerType $customerType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerType $customerType)
    {
        $title = "Customer Type";
        $description = "Some description for the page";
        return view('pages.settings.cus_type.edit', compact('title', 'description','customerType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerType $customerType)
    {
        $customerType->fill($request->all())->save();
        return redirect('customer-type');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerType $customerType)
    {
        //
    }

    public function status($id){
        $enqutype = CustomerType::findOrFail($id);
      if($enqutype->status == 1){
        $enqutype->status = 0;
       
      }else{
        $enqutype->status = 1;
      }
      $enqutype->save();

      return  redirect()->back()->with('success', 'Success! Status Change');
    }
}
