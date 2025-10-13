<?php

namespace App\Http\Controllers;

use App\Models\ShowRoomUser;
use App\Models\ShowRoom;
use Illuminate\Http\Request;
use Auth;

class ShowRoomUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "User List";
        $description = "Some description for the page";
        // Query
        $query = ShowRoomUser::with(['users','showrooms']);
        // Keyword
        if($request->keyword){
            $query->whereRaw("(name like '%$request->keyword%' or phone like '%$request->keyword%')");
        }
        $users = $query->orderBy('id','DESC')->paginate(30);

        return view('pages.showroomuser.index',compact('title','description','users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "User List";
        $description = "Some description for the page";
        // Query

        $showrooms = ShowRoom::latest()->get();

        return view('pages.showroomuser.create',compact('title','description','showrooms'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $number_check = ShowRoomUser::where('phone',$request->phone)->get();
            if(count($number_check) > 0){
                return  redirect()->back()->with('error', 'Mobile Number Already Exists');
            }
                $user = new ShowRoomUser();
                $request['created_by'] = Auth::user()->id;

                $user->fill($request->all())->save();
                return  redirect('show-room-user')->with('success', 'Success! User Create');

        } catch (\Exception $e) {
            return  redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowRoomUser $showRoomUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = "Edit User";
        $description = "Some description for the page";
        $user = ShowRoomUser::with(['users','showrooms'])->findOrFail($id);
        $showrooms = ShowRoom::orderBy('id','DESC')->get();
        return view('pages.showroomuser.edit',compact('title','description','showrooms','user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $user = ShowRoomUser::findOrFail($id);
        $user->fill($request->all())->save();

        return redirect('show-room-user')->with('success', 'Success! Update User');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShowRoomUser $showRoomUser)
    {
        //
    }
}
