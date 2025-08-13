<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomerExport;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Customer Type";
        $description = "Some description for the page";
        $query = Customer::with(['users', 'customer_types']);

        // Apply query constraints based on the user's role
                $query->when(Auth::user()->role_id != 1, function ($q) {
                    $q->where('showroom_id', Auth::user()->showroom_id);
                });

       $query->when($request->filled('keyword'), function ($q) use ($request) {
                $keyword = $request->keyword;
                $q->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('name', 'like', "%{$keyword}%")
                            ->orWhere('email', 'like', "%{$keyword}%")
                            ->orWhere('number', 'like', "%{$keyword}%");
                });
            });

        // Get the total number of records
                $total = $query->count();

        // Retrieve paginated customers, ordered by ID in descending order
                $customers = $query->orderBy('id', 'DESC')->paginate(30);

        return view('pages.settings.customer.index', compact('title', 'description','total','customers'));
    }

    public function export(){

        $users = Customer::with(['users','customer_types','upazila','district'])->orderBy('id','DESC')->get();
        return Excel::download(new CustomerExport($users), 'customer-report.xlsx');

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
    public function status($id)
    {
        $status_update = Customer::findOrFail($id);
        if($status_update->status == 1){
            $status_update->status = 0;
        }else{
            $status_update->status = 1;
        }
        $status_update->save();

      return  redirect()->back()->with('success', 'Success! Status Change');
    }
}
