<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Role;
use Modules\User\Entities\Permission;
use Illuminate\Validation\Rule;
use DB;
use Validator;

class RoleController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $roles = Role::orderBy('id','DESC')->paginate(10);
        return view('user::role.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $permission = Permission::get();
        return view('user::role.create',compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
    
        if($validated){
            $role = Role::create(['name' => $request->input('name'), 'guard_name' => 'api']);
            $role->syncPermissions($request->input('permission'));
        }      
    
        return redirect()->route('roles.index')
                        ->with('success','Role created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
    
        return view('user::role.show',compact('role','rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
    
        return view('user::role.edit',compact('role','permission','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        // Check unique data
        $roles = Role::all();
        $role = Role::find($id);
        foreach($roles as $item){
            if($item->name == $request->input('name') && $role->name != $request->input('name')){
                return redirect()->back()
                                ->with('errors','This name has already taken.');
            }
        }

        // Update data
        $validated = $request->validate([
            'name' => 'required',
            'permission' => 'required',
        ]);
    
        if($validated){
            $role->name = $request->input('name');
            $role->save();
        
            $role->syncPermissions($request->input('permission'));
        
            return redirect()->route('roles.index')
                            ->with('success','Role updated successfully');
        }
        else{
            return redirect()->back()
                            ->with('errors','Something weng wrong.');
        }
        
        
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
                        ->with('success','Role deleted successfully');
    }
}
