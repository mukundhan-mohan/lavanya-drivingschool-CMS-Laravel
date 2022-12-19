<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\LeftMenu;
use App\Http\Requests\StaffRequest;
use App\Models\UserMenuPrivilege;
use App\Helpers\CustomHelper;
use DB;

class PermissionsController extends Controller
{
    private $adminRoles = [];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct() {
        $this->adminRoles = [1, 2];
      }
      
      
    public function index(Request $request)
    {
        $q = User::query();
        
        $q->where('has_deleted', 0);

        $q->join("role_user", "role_user.user_id", "=", "users.id");

        $q->whereIn("role_user.role_id", [1,2]);

        $users = $q->select(['users.id', 'users.name', 'role_user.role_id', 'users.email'])->orderBy('users.created_at', 'DESC')->groupBy("users.id")->paginate(20);
        $roles = Role::whereIn("id", $this->adminRoles)->get();

        return view('admin.permissions.index', compact('users', 'roles'));
    }

    public function manage(Request $request, User $user) {
        $data['user'] = $user;
        $data['groups']['group1'] = LeftMenu::select(['id', 'left_menu'])->whereIn("slug", array_keys(config("lavanya.left_menus_g1")))->get();

        $data['icons']['group1'] = config("lavanya.left_menu_icons")["g1"];

        $data['userMenus'] = UserMenuPrivilege::where("user_id", $user->id)->pluck("left_menu_id")->toArray();
        return view('admin.permissions.manage', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $roles = $this->userRoles();
        return view('admin.access-staffs.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // print_r($request->user_type);
        // exit();
        $inputs = $request->except(['avatar', 'user_type']);
        $inputs['created_by'] = Auth::user()->id;
        $inputs['updated_by'] = Auth::user()->id;
        $user = User::create( $inputs );
        $user->roles()->attach($request->get('user_type'));
        if($user->isAdmin) {
            $leftMenus = LeftMenu::all();
            UserMenuPrivilege::where('user_id', $user->id)->delete();
            foreach($leftMenus as $leftMenu) {
                $n = new UserMenuPrivilege();
                $n->user_id = $user->id;
                $n->left_menu_id = $leftMenu->id;
                $n->menu_slug = $leftMenu->slug;
                $n->creator_id = 1;
                $n->updated_by = 1;
                $n->save();
            }
        }
        return redirect()->back()->withSuccess("Record created successfully! Please provide a required permissions.");
    }

    public function save(Request $request, User $user) {
        $datas = $request->data;
        if(is_array($datas)) {
            if(count($datas) > 0) {
                foreach($datas as $key => $data) {
                    if($data == 0) {
                        UserMenuPrivilege::where("user_id", $user->id)->where("left_menu_id", $key)->delete();
                    }
                    if($data == 1) {
                        $uP = UserMenuPrivilege::where("user_id", $user->id)->where("left_menu_id", $key)->first();
                        if(!$uP) {
                            $uP = new UserMenuPrivilege();
                            $uP->creator_id = auth()->user()->id;
                        }
                        $uP->updated_by = auth()->user()->id;
                        $uP->user_id = $user->id;
                        $uP->menu_slug = LeftMenu::select(['slug'])->where('id', $key)->first()->slug;
                        $uP->left_menu_id = $key;
                        $uP->save();
                    }
                }
            }
        }
        return response()->json([
            'message' => config('apiresponses.get'),
            'error'   => 0,
            'data'    =>  UserMenuPrivilege::where("user_id", $user->id)->pluck("left_menu_id")->toArray()
        ]);
    }

    public function changeRole(Request $request, User $user) {
        if($request->role_id) {
            DB::table("role_user")->where("user_id", $user->id)->delete();
            $user->roles()->attach($request->role_id);
            return response()->json([
                'message' => config('apiresponses.get'),
                'error'   => 0,
                'data'    => 1
            ]);
        }
        return response()->json([
            'message' => config('apiresponses.get'),
            'error'   => 0,
            'data'    => 0
        ]);
    }

    public function passwordChange(Request $request, User $user) {
        $authUser = User::find(auth()->user()->id);
        $authUser->pw_code = CustomHelper::sixDigitCode();
        $authUser->save();
        $subject = "Somebody is trying to change your password";
        // $email = $authUser->email;
        // if(in_array($authUser->email, ['koalaadmin@go-koala.com'])) {
        //     $email = "dev@go-koala.com";
        // }
        // Mail::to($email)->send(new \App\Mail\SaffPwCodeMail($authUser, $user, $subject)); 
        
        return response()->json([
            'message' => config('apiresponses.get'),
            'error'   => 0,
            'data'    =>  ""
        ]);
    }

    public function verifyPw(Request $request, User $user) {
        $authUser = User::find(auth()->user()->id);
        if($authUser->pw_code == $request->otp) {
            $authUser->pw_code = "";
            $authUser->timestamps = false;
            $authUser->save();
            return response()->json([
                'message' => config('apiresponses.get'),
                'error'   => 0,
                'data'    =>  ""
            ]);
        }
        return response()->json([
            'message' => config('apiresponses.get'),
            'error'   => 1,
            'data'    =>  ""
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user) {
        $roles = $this->userRoles();
        return view('admin.access-staffs.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StaffRequest $request, User $user) {
        $inputs = $request->except(['_method', '_token', 'user_type']);
        if($request->get('password') == "") {
            unset($inputs['password']);
        } else {
            $inputs['password'] = bcrypt($inputs['password']);
        }
        User::where('id', $user->id)->update($inputs);
        $user = User::find($user->id);
        if($request->get('user_type') != "") {
            DB::table('role_user')->where('user_id', $user->id)->delete();
            $user->roles()->attach($request->get('user_type'));
            $user->save();
        }
        return redirect()->action('Admin\PermissionsController@index')->withSuccess("Record updated successfully!");;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    

    public function userRoles() {
        $roles = Role::select(['id', 'role', 'name'])->whereIn("id", [ 1,2])->get();
        $userRoles = [];
        if(count($roles) > 0)
        {
            foreach($roles as $key => $role) {
                $userRoles[$role->id] = $role->name; 
            }
        }
        return $userRoles;
    }

    public function delete(Request $request, $id)
    {
        $user = User::find($id);
        if($user) {
            $user->has_deleted = 1;
            $user->updated_by = Auth::user()->id;
            $user->save();
        }
        if($request->ajax()){
            return response()->json(['status' => 200, 'message' => 'Record deleted successfully!'], 200); 
        }
        return redirect()->action('Admin\PermissionsController@index')->withSuccess("Record deleted successfully!");
    }
}
