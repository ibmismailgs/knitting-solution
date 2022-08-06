<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Permission;
use DB;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $permissions = Permission::orderBy('id','DESC')->paginate(10);
        return view('user::permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('user::permission.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:permissions,name'
        ]);
    
        if($validated){
            Permission::create(['name' => $request->input('name'), 'guard_name' => 'api']);
        }
    
        return redirect()->route('permissions.index')->with('success','Permission created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('user::permission.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('user::permission.edit', compact('permission'));
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
            'name' => 'required|unique:permissions,name'
        ]);
    
        if($validated){
            $permission = Permission::find($id);
            $permission->name = $request->input('name');
            $permission->save();
        
            return redirect()->route('permissions.index')
                            ->with('success','Permission updated successfully');
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
        DB::table("permissions")->where('id',$id)->delete();
        return redirect()->route('permissions.index')->with('success','Permission deleted successfully');
    }
}
