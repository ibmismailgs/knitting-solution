<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\User;
use Modules\User\Entities\Role;
use Modules\User\Entities\Permission;
use Auth;
use Hash;
use Arr;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $users = User::orderBy('id','DESC')->paginate(10);
        return view('user::user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('user::user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:password_confirmation',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('user::user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        $permission = Permission::get();
        $userPermissions = DB::table("model_has_permissions")->where("model_has_permissions.model_id",$id)
            ->pluck('model_has_permissions.permission_id','model_has_permissions.permission_id')
            ->all();
    
        return view('user::user.edit',compact('user','roles','userRole', 'permission', 'userPermissions'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:password_confirmation'
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }
    
        $user = User::find($id);
        $user->update($input);

        if(isset($request->pro_page) && $request->pro_page == 1){
            return redirect()->back()
            ->with('success','Profile updated successfully');
        }else{
            DB::table('model_has_roles')->where('model_id',$id)->delete();
            $user->assignRole($request->input('roles'));

            // Remove previous permissions
            DB::table('model_has_permissions')->where('model_id',$id)->delete();
            // Adding permissions to a user
            $user->givePermissionTo($request->input('permission'));

            return redirect()->route('users.index')
                        ->with('success','User updated successfully');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user::user.profile',compact('user'));
    }
}
