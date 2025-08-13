<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use Auth;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Bank Name ";
        $description = "Some description for the page";
        $query = Bank::with('users')->orderBy('id','DESC');
        
        // Keyword
        if ($request->keyword) {
            $query->where('name', 'like', "%$request->keyword%");
        }
        $banks = $query->paginate(30);

        return view('pages.settings.bank.index', compact('title', 'description', 'banks'));
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
            'name' => 'required|string|max:255|unique:banks,name',
        ]);

        $bank = new Bank();

        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $bank->fill($data)->save();

        return  redirect()->back()->with('success', 'Success! Create Bank');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = "Bank Edit";
        $description = "Some description for the page";
        $bank = Bank::findOrFail($id);
        return view('pages.settings.bank.edit', compact('title', 'description', 'bank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $bank = Bank::findOrFail($id);
        $bank->fill($request->all())->save();
        return  redirect('banks')->with('success', 'Success! Update Bank');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $bank)
    {
        //
    }
}
