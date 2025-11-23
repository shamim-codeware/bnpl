<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;
use App\Models\Menu;
use App\Models\MenuPermission;
use App\Models\SourcePermission;
use App\Models\EnquirySource;
use App\Models\Zone;
use App\Models\User;
use App\Models\ZonePermission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Role";
        $description = "Some description for the page";
        // Query
        $query = Role::query();
        // Keyword
        if($request->keyword){
            $query->where('name', 'like', "%$request->keyword%");
        }
        $roles = $query->orderBy('id','DESC')->get();

        return view('pages.settings.role.index', compact('title', 'description','roles'));
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
        $roles = new Role();
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $roles->fill($data)->save();
        return  redirect()->back()->with('success', 'Success! Create Customer');
    }


    public function ZonePermission(){
        $title = "User Create";
        $description = "Some description for the page";
        $exusers = User::where('role_id', 6)->orderBy('id', 'DESC')->get();
        // if(Auth::user()->role_id == 6){
        // $exusers = User::where('role_id',2)->where('zone_id',Auth::user()->zone_id)->orderBy('id','DESC')->get();
        // }
        $allzones = Zone::orderBy('id','DESC')->get();
        return view('pages.user.permission', compact('title', 'description', 'exusers', 'allzones'));
    }

    public function CehckZonePermission($user_id){
        $user =  User::where('id', $user_id)->first();
        $permission = json_decode($user->showroom_permission);
        $allzone = Zone::orderBy('id', 'DESC')->get();
        $permission = ZonePermission::where('user_id',$user->id)->pluck('zone_id')->toArray();
        return view('pages.user.permission-list',compact('allzone', 'permission'));
    }

    public function ZoneAssign(Request $request ){
        $user_id = $request->user_id;
        $ShowRoomPermission = new ZonePermission;
        ZonePermission::where('user_id',$user_id)->delete();
        foreach($request->showroom_id as $row){
            $data['user_id'] =  $user_id ;
            $data['zone_id'] = $row;
            ZonePermission::create($data);
        }

        return response()->json(['status' => 1, 'message' => 'Success! Save'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $title = "Role";
        $description = "Some description for the page";
        return view('pages.settings.role.permission', compact('title', 'description','role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $title = "Customer Type";
        $description = "Some description for the page";
        return view('pages.settings.role.edit', compact('title', 'description','role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $role->fill($request->all())->save();
        return  redirect('roles')->with('success', 'Success! Update Role');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }

    public function status($id)
    {
        $role = Role::findOrFail($id);
        if($role->status == 1){
            $role->status = 0;
        }else{
            $role->status = 1;
        }
        $role->save();

        return  redirect()->back()->with('success', 'Success! Status Change Successfully');
    }

    public function menuPermission()
    {
        $title = "Menu Permission";
        $description = "Some description for the page";
        $menus = Helper::menus_permission();
        $roles = Role::where('status', 1)->get();

        return view('pages.settings.role.menu-permission', compact('title', 'description', 'menus', 'roles'));
    }
    public function menuAssign($role_id)
    {
        return MenuPermission::where('role_id', $role_id)->get();
    }
    public function menuPermissionAssign(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'permission' => 'required|array',
            'role_id'    => 'required|numeric|exists:roles,id',
        ],[
            'role_id.required'    => 'Select role',
            'permission.required' => 'Select permission',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }
        else{
            $permissions = [];
            foreach($request->input('permission') as $key => $p){
                $permissions[] = ['menu_id' => $key, 'action' => $p];
            }
            MenuPermission::where('role_id', $request->input('role_id'))->delete();
            // Menu permission
            foreach($permissions as $per){
                $permission              = new MenuPermission();
                $permission->role_id     = $request->input('role_id');
                $permission->menu_id     = $per['menu_id'];
                $permission->action      = $per['action'];
                $permission->created_by  = Auth::user()->id;
                $permission->save();
            }

            return response()->json(['status' => 1, 'message' => 'Success! Save'], 200);
        }
    }
    function menu_entry(){
        // $menus = Helper::menus();
        //     foreach ($menus as $m){
        //     $menu              = new Menu();
        //     $menu->title       = $m['title'];
        //     $menu->url         = $m['url'];
        //     $menu->icon        = $m['icon'];
        //     $menu->parent_id   = 0;
        //     $menu->created_by  = Auth::user()->id;
        //     $menu->save();

        //     if ($m['children']){
        //         foreach ($m['children'] as $c){
        //             $me              = new Menu();
        //             $me->title       = $c['title'];
        //             $me->url         = $c['url'];
        //             $me->icon        = $c['icon'];
        //             $me->parent_id   = $menu->id;
        //             $me->created_by  = Auth::user()->id;
        //             $me->save();

        //         }
        //     }
        // }
        exit;
    }

    public function SourcePermission(){

        $title = "Menu Permission";
        $description = "Some description for the page";
        $roles = Role::where('status', 1)->get();
        return view('pages.user.permission', compact('title', 'description', 'roles'));
    }

    public function CehckPermission($role_id)
    {
        $role =  Role::where('id', $role_id)->first();
        $allSorce = EnquirySource::orderBy('id', 'DESC')->where('parent_id',0)->get();
        $permission = SourcePermission::where('role_id', $role->id)->pluck('source_id')->toArray();
        return view('pages.user.permission-list', compact('allSorce', 'permission'));
    }

    public function SourceAssign(Request $request)
    {

        $user_id = $request->user_id;
        $ShowRoomPermission = new SourcePermission;
        SourcePermission::where('role_id', $user_id)->delete();

        foreach ($request->showroom_id as $row) {
            $data['role_id'] =  $user_id;
            $data['source_id'] = $row;

            SourcePermission::create($data);
        }

        return response()->json(['status' => 1, 'message' => 'Success! Save'], 200);
    }
}
