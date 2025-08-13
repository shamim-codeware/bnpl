<?php

namespace App\Http\Controllers;

use App\Models\InterestRate;
use Illuminate\Http\Request;
use Auth;

class InterestRateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Interest Rate ";
        $description = "Some description for the page";
        $query = InterestRate::with(['users','updateusers']);
        // Keyword
        if ($request->keyword) {
            $query->where('month','like',"%$request->keyword%");
        }
        $interestrates = $query->orderBy('month', 'ASC')->paginate(30);
        return view('pages.settings.interestrate.index', compact('title','description','interestrates'));
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
            'month' => 'required|unique:interest_rates,month',
            'interest_rate' => 'required'
        ]);

        $data = $request->all();

        $data['created_by'] = Auth::user()->id;

        $interestRate = new InterestRate;
        $interestRate->fill($data)->save();

        return  redirect()->back()->with('success', 'Success! Create Interest Rate');
    }

    /**
     * Display the specified resource.
     */
    public function show(InterestRate $interestRate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = "Interest Rate ";
        $description = "Some description for the page";
         $InterestRate = InterestRate::findOrFail($id);
        return view('pages.settings.interestrate.edit', compact('title', 'description','InterestRate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InterestRate $interestRate)
    {

        $data = $request->all();

        $data['updated_by'] = Auth::user()->id;

        $interestRate->fill($data)->save();
        return  redirect('interest-rate')->with('success', 'Success! Update Interest Rate');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InterestRate $interestRate)
    {
        //
    }
}
