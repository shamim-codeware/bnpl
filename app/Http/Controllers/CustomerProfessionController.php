<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerProfession;
use Illuminate\Support\Facades\Auth;

class CustomerProfessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Customer Profession";
        $description = "Some description for the page";
        // Query
        $query = CustomerProfession::with('users');
        // Keyword
        if($request->keyword){
            $query->where('name', 'like', "%$request->keyword%");
        }
        $professions = $query->orderBy('id','DESC')->paginate(30);

        return view('pages.settings.cus_profession.index', compact('title', 'description','professions'));
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

        $enquerytype = new CustomerProfession();
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $enquerytype->fill($data)->save();
        return  redirect()->back()->with('success', 'Success! Create Customer Profession');
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerProfession $customerProfession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerProfession $customerProfession)
    {
        $title = "Customer Type";
        $description = "Some description for the page";
        return view('pages.settings.cus_profession.edit', compact('title', 'description','customerProfession'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerProfession $customerProfession)
    {
        $customerProfession->fill($request->all())->save();
        return redirect('customer-profession')->with('success', 'Success! Update Customer Profession');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerProfession $customerProfession)
    {
        //
    }

    public function status($id){
        $status_update = CustomerProfession::findOrFail($id);
        if($status_update->status == 1){
            $status_update->status = 0;
        }else{
            $status_update->status = 1;
        }
        $status_update->save();

      return  redirect()->back()->with('success', 'Success! Status Change');
    }
}
