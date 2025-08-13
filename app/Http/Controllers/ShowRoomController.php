<?php

namespace App\Http\Controllers;

use App\Models\ShowRoom;
use App\Models\Zone;
use Illuminate\Http\Request;
use DB;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ShowroomExport;

class ShowRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Enquiry Type";
        $description = "Some description for the page";
        $query = ShowRoom::with(['users','district','upazila','zone'])->orderBy('name','ASC');
        if($request->keyword){
            $query->where('name', 'like', "%$request->keyword%");
        }
        if($request->zone_id){
            $query->where('zone_id',$request->zone_id);
        }
        if($request->store_type){
            $query->where('dealar',$request->store_type);
        }
        $zones    = Zone::orderBy('id','ASC')->where('status',1)->get();
        $total =  $query->count();
        $showrooms  = $query->paginate(30);

        return view('pages.settings.show_room.index', compact('title','zones','total','description','showrooms'));
    }

    public function ShowRoomCredit(Request $request){

        $title = "Enquiry Type";
        $description = "Some description for the page";
        $query = ShowRoom::with(['users','district','upazila','zone'])->orderBy('name','ASC');
        if($request->keyword){
            $query->where('name', 'like', "%$request->keyword%");
        }
        if($request->zone_id){
            $query->where('zone_id',$request->zone_id);
        }
        if($request->store_type){
            $query->where('dealar',$request->store_type);
        }
        $zones    = Zone::orderBy('id','ASC')->where('status',1)->get();
        $total =  $query->count();
        $showrooms  = $query->paginate(30);

        return view('pages.settings.show_room.credit', compact('title','zones','total','description','showrooms'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Show Room Create";
        $description = "Some description for the page";
        $districts = DB::table('districts')->orderBy('id','DESC')->where('status',1)->get();
        $thanas = DB::table('upazilas')->orderBy('id','DESC')->where('status',1)->get();
        $zones    = Zone::orderBy('id','DESC')->where('status',1)->get();
        return view('pages.settings.show_room.create', compact('title', 'description','districts','thanas','zones'));
    }

    public function FindUpazila(Request $request){
       $upazilas =  DB::table('upazilas')->where('status',1)->where('district_id',$request->district_id)->orderBy('id','DESC')->get();
       return json_encode($upazilas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $showrooms = new ShowRoom();
        $data = $request->all();
        $data['remaining_credit'] = $request->credit_score;
        $data['created_by'] = Auth::user()->id;
        // return $data;
        $showrooms->fill($data)->save();
        return  redirect('show-rooms')->with('success', 'Success! Create Show Room');

    }

    /**
     * Display the specified resource.
     */
    public function show(ShowRoom $showRoom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = "Show Room Create";
        $description = "Some description for the page";
        $showroom = ShowRoom::where('id',$id)->with(['users','district','upazila','zone'])->orderBy('id','DESC')->first();
        $districts = DB::table('districts')->orderBy('id','DESC')->get();
        $thanas = DB::table('upazilas')->orderBy('id','DESC')->get();
        $zones    = Zone::orderBy('id','DESC')->get();
        return view('pages.settings.show_room.edit',compact('title', 'description','showroom','districts','thanas','zones'));
    }

    /**
     * Update the specified resource in stozrage.
     */
    public function update(Request $request, ShowRoom $showRoom)
    {
        $data = $request->all();
        if($request->dealar){
        $data['dealar'] = 1;
            }else{
                $data['dealar'] = 0;
            }
        $showRoom->fill($data)->save();
        return  redirect('show-rooms')->with('success', 'Success! Update Show Room');
    }

    public function ShowroomExport(){

        $users = ShowRoom::with(['users','district','upazila','zone'])->orderBy('id','DESC')->get();
        return Excel::download(new ShowroomExport($users), 'Showroom-report.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShowRoom $showRoom)
    {
        //
    }

    public function status($id)
    {
        $status_update = ShowRoom::findOrFail($id);
        if($status_update->status == 1){
            $status_update->status = 0;
        }else{
            $status_update->status = 1;
        }
        $status_update->save();

      return  redirect()->back()->with('success', 'Success! Status Change');
    }
}
