<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use Exception;
use App\Models\Zone;
use App\Models\ShowRoom;
use App\Models\CreditScor;
use App\Models\ShowRoomUser;
use Illuminate\Http\Request;
use App\Models\ShowroomCredit;
use Illuminate\Support\Facades\DB;

class CreditScorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Customer Type";
        $description = "Some description for the page";
        $showroomusers = ShowRoomUser::where('showroom_id',Auth::user()->showroom_id)->latest()->get();
        return view('installment.credit_score.steps',compact("title","description","showroomusers"));
    }

    /**
     * Show the form for creating a new resource.
     *                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
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

        // dd($request->all());
      $total = 0 ; 
        $total += $request->age + $request->customer_status + $request->monthly_income + $request->profession + $request->length_profession + $request->family_size + $request->residence_status + $request->permanent_address_mentioned + $request->distance + $request->gaurantors + $request->educational_qualification;
        if(($total >= 60) || ($request->is_approved_id)){
            $CreditScor = new CreditScor;
            $CreditScor->fill($request->all())->save();
            session()->put('credit_id', $CreditScor->id);
            session()->put('showroom_user_id',$request->showroom_user_id);
            return  redirect('hire-purchase')->with('success', 'Success! You Are Capable ');
        }else{
            return  redirect()->back()->with('error', 'Success! You Are Not Capable');
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(CreditScor $creditScor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CreditScor $creditScor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, CreditScor $creditScor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CreditScor $creditScor)
    {
        //
    }

    public function showroomCredit(Request $request)
    {
        $show_rooms = ShowRoom::active()->get();
        $zones = Zone::active()->get();
        $query = ShowroomCredit::with('show_room.zone', 'user');

        if ($showroom = $request->showroom_id) {
            $query->whereHas('show_room', function ($q) use ($showroom) {
                $q->where('showroom_id', $showroom);
            });
        }
        if ($zone = $request->zone_id) {
            $query->whereHas('show_room.zone', function ($q) use ($zone) {
                $q->where('zone_id', $zone);
            });
        }
        try {
            $showroomCredit = $query->paginate(20);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

        return view('report.credit_score', compact('show_rooms', 'zones', 'showroomCredit'));
    }

    public function showroomCreditStore(Request $request)
    {
        $id = $request->id;
        try {
            $data = $request->validate([
                'id' => 'nullable|exists:showroom_credits,id',
                'showroom_id' => 'required|exists:show_rooms,id',
                'credit' => 'required|numeric',
            ]);

            $data['created_by'] = auth()->user()->id;

            $message = "";

            DB::transaction(function () use ($id, $data, &$message) {
                if (isset($id)) {
                    $showroomCredit = ShowroomCredit::find($id);
                    if ($showroomCredit) {
                        $showroomCredit->update($data);
                        //here updating showroom credit and remaining amount after updating showroom credit
                        $showroom = ShowRoom::find($data['showroom_id']);
                        $showroom->credit_score += $data['credit'];
                        $showroom->remaining_credit += $data['credit'];
                        $showroom->save();
                        $message = 'Showroom Credit updated successfully';
                    } else {
                        $message = "Showroom Credit not found";
                    }
                } else {
                    ShowroomCredit::create($data);
                    //here inserting showroom credit and remaining amount after inserting showroom credit
                    $showroom = ShowRoom::find($data['showroom_id']);
                    $showroom->credit_score += $data['credit'];
                    $showroom->remaining_credit += $data['credit'];
                    $showroom->save();
                    $message = 'Showroom Credit assigned successfully';
                }
            }, 5);

            return redirect()->back()->with('success', $message);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }



}
