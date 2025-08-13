<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;
use App\Models\ShowRoom;
use App\Models\User;
use App\Models\Role;
use App\Models\Zone;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;

class UserController extends Controller {

    /**
     * Display user members of the resource.
     *
     * @return \Illuminate\View\View
     */

    //  public function list(){

    //  }
    public function index(Request $request){
        $title = "User List";
        $description = "Some description for the page";
        // Query
        $query = User::with(['users','roles','showrooms']);
        // Keyword
        if($request->keyword){
            $query->whereRaw("(name like '%$request->keyword%' or email like '%$request->keyword%' or phone like '%$request->keyword%')");
        }
        $users = $query->orderBy('name','ASC')->paginate(30);

        return view('pages.user.list',compact('title','description','users'));
    }

    public function export(){

        $users = User::with(['roles','showrooms','showrooms.zone'])->orderBy('id','DESC')->get();
        return Excel::download(new UsersExport($users), 'user-report.xlsx');
    }
    /**
     * Display user list of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(){
        $title = "Add User";
        $description = "Some description for the page";
        $showrooms = ShowRoom::orderBy('name','ASC')->where('status',1)->get();
        $roles = Role::orderBy('name','ASC')->where('status',1)->get();
        $zones    = Zone::orderBy('id','ASC')->where('status',1)->get();

        return view('pages.user.create',compact('title','description','showrooms','roles','zones'));
    }
    public function store(Request $request){
        // dd($request->all());
        try {
            $number_check = User::where('phone',$request->phone)->get();
            if(count($number_check) > 0){
                return  redirect()->back()->with('error', 'Mobile Number Already Exists');
            }
            if($request->password == $request->c_password){
                $user = new User();
                $request['password'] = Hash::make($request->password);
                $request['created_by'] = Auth::user()->id;

                $user->fill($request->all())->save();
                return  redirect('user')->with('success', 'Success! User Create');
            }else{
                return  redirect()->back()->with('error', 'Confirm Password Not Matched');
            }
        } catch (\Exception $e) {
            return  redirect()->back()->with('error', 'Something went wrong');
        }
    }
    public function edit($id)
    {
        $title = "Edit User";
        $description = "Some description for the page";
        $user = User::with(['users','zones','roles','showrooms'])->findOrFail($id);
        $showrooms = ShowRoom::orderBy('id','DESC')->get();
        $roles = Role::orderBy('id','DESC')->get();

        $zones    = Zone::orderBy('id','ASC')->where('status',1)->get();
        return view('pages.user.edit',compact('title','description','zones','showrooms','roles','user'));
    }
    public function update(Request $request,$id)
    {
       $user = User::findOrFail($id);
       $user->fill($request->all())->save();

       return redirect('user')->with('success', 'Success! Update User');
    }
    public function status($id)
    {
        $status_update = User::findOrFail($id);
        if($status_update->status == 1){
            $status_update->status = 0;
        }else{
            $status_update->status = 1;
        }
        $status_update->save();

      return  redirect()->back()->with('success', 'Success! Status Change');
    }



    public function Profile($id)
    {
        $users = User::findOrFail($id);

        $title = "User Create";
        $description = "Some description for the page";
        return view('pages.user.profile',compact('title','description','users'));
    }

    public function UpdateProfile(Request $request,$id){
//dd($request->all());
        $data = $request->all();
           if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('Users'), $fileName);
                $data['profile_photo_path'] = 'Users/' . $fileName;
           }
           $user = User::findOrFail($id);
           $user->fill($data)->save();
           return redirect()->back()->with('success', 'Update Successfully!');
    }

    public function ChangePassword($id){
        $users = User::findOrFail($id);

        $title = "User Password Change";
        $description = "Some description for the page";
        return view('pages.user.change-password',compact('title','description','users'));
    }

    public function UserPasswordChange($id){

        $users = User::findOrFail($id);
        $title = "User Password Change";
        $description = "Some description for the page";
        return view('pages.user.change-password-user',compact('title','description','users'));
    }

    public function UpdatePassword(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'password_c' => 'required'
        ]);
        $user_id =  Auth::user()->id;
        if(!(Hash::check($request->get('old_password'), Auth::user()->password))) {
            return redirect()->back()->with('error', 'Old Password Has Not Matched');
        }
        if(strcmp($request->get('old_password'), $request->get('new_password')) == 0){
            return redirect()->back()->with('error', 'New Password cannot be same as your current password. Please choose a different password.');
        }
        if($request->get('new_password') != $request->get('password_c')){
            return redirect()->back()->with('error', 'New Password and Confirm New Password does not match.');
        }
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new_password'));
        $user->save();

        return redirect()->back()->with('success', 'Password Change Successfully ');
    }

    public function UpdatePasswordUser(Request $request,$id){

        $request->validate([
            'new_password' => 'required',
            'password_c' => 'required'
        ]);
        $user_id =  Auth::user()->id;

        if($request->get('new_password') != $request->get('password_c')){
            return redirect()->back()->with('error', 'New Password and Confirm New Password does not match.');
        }
        //Change Password
        $user = User::findOrFail($id);
        $user->password = bcrypt($request->get('new_password'));
        $user->save();

        return redirect()->back()->with('success', 'Password Change Successfully ');
    }

    public function ActiveUserManager(Request $request){

        $title = "Active User";
        $description = "Some description for the page";
        $role_id = $request->user;
        $users = User::where('role_id', 3)->where('is_active',1)->paginate(30);

        return view('pages.user.activelist',compact('title','description','users','role_id'));
    }

    public function ActiveUserExecutive(Request $request){

        $title = "Active User";
        $description = "Some description for the page";
        $role_id = $request->user;
        $users = User::where('role_id', 2)->where('is_active',1)->paginate(30);

        return view('pages.user.activelist',compact('title','description','users','role_id'));
    }

    public function ActiveUserAdmin(Request $request){

        $title = "Active User";
        $description = "Some description for the page";
        $role_id = $request->user;
        $users = User::where('role_id', 1)->where('is_active',1)->paginate(30);

        return view('pages.user.activelist',compact('title','description','users','role_id'));
    }


    public function Activeexport(Request $request){
        $role_id = $request->role_id;
        $users = User::where('role_id', $role_id)->where('is_active',1)->get();
        return Excel::download(new UsersExport($users), 'user-report.xlsx');
    }
}
