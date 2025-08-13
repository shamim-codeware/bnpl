<?php

namespace App\Http\Controllers;

use App\Models\Penalty;
use Illuminate\Http\Request;

class PenaltyController extends Controller
{

    // public function store(Request $request, $id){
    //    $data = $this->validate($request, [
    //         'penalty' => 'required',
    //     ]);
    //     $message = isset($data['id'] ) ? "Penelty Updated Successfully" : "Penalty Created Successfully";
    //     if($data['id']){
    //         $penalty =  Penalty::find($data['id']);
    //         $penalty->update($data);
    //     }else{
    //         $penalty = new Penalty();
    //         $penalty->create($data);
    //     }
       
    //     return redirect()->back()->with('success',$message);
    // }



    public function index()
    {
        $title = "Penalty";
        $description ="Some Description Here";
        return view('pages.settings.penalty.index', compact('title','description'));
    }
    public function store(Request $request, $id = null)
    {
        $data = $request->validate([
            'penalty' => 'required',
        ]);
        $message = $id ? "Penalty Updated Successfully" : "Penalty Created Successfully";
        Penalty::updateOrCreate(['id' => $id], $data);
        return redirect()->back()->with('success', $message);
    }

}
