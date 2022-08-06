<?php

namespace Modules\Yarn\Http\Controllers;

use Auth;
use Hash;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\User\Entities\Role;
use Modules\User\Entities\User;
use Illuminate\Routing\Controller;
use Modules\Yarn\Entities\Employee;
use Illuminate\Contracts\Support\Renderable;
use Modules\PartyOrderDetails\Entities\KnittingProductionDetail;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $auth = Auth::user();
        $user_role = $auth->roles->first();
        $employees = Employee::all();
        return view('yarn::employee.index', compact('employees','user_role'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('yarn::employee.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $data = $request->except('image');
        if(isset($data['add_user'])){
            $validated = $request->validate([
                'email' => 'required|email|unique:users,email',
                'password' => 'required|same:password_confirmation',
            ]);


            $data['password'] = bcrypt($data['password']);
            $user=User::create($data);
            $user->assignRole($request->input('roles'));
            // $user = User::latest()->first();
            // $data['user_id'] = $user->id;
        }
        //
        $validated = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'dob' => 'required'
        ]);

        // $input = $request->all();
        // $input['password'] = Hash::make($input['password']);

        // $user = User::create($input);
        // $user->assignRole($request->input('roles'));
        $image = $request->image;
        if ($image) {
            $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = preg_replace('/[^a-zA-Z0-9]/', '', $request['email']);
            $imageName = $imageName . '.' . $ext;
            $image->move('admin/employee_img', $imageName);
            $data['image'] = $imageName;
        }

        if($validated){
            Employee::create([
                'name'=>$request->name,
                'image'=>$imageName?? '',
                'phone'=>$request->phone,
                'dob'=>$request->dob,
                'user_id'=> $user->id?? Null,
                'f_name'=> $request->f_name,
                'm_name'=> $request->m_name,
                'nid'=> $request->nid,

                'present_address'=>$request->present_address,
                'permanent_address'=>$request->permanent_address,
                'join_date'=>$request->join_date,
                'created_by'=>Auth::user()->id,
            ]);
        }

        return redirect()->route('employee.index')
                        ->with('success','Employee created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $date = Carbon::now();
        $employee = Employee::find($id);
        $joblength=$employee->join_date;
        $job_duration=Carbon::parse($date)->diff($joblength);
        return view('yarn::employee.view', compact('employee','job_duration'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        return view('yarn::employee.edit', compact('employee'));
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
            'phone' => 'required',
            'dob' => 'required'
        ]);

        if($validated){
            $image = $request->image;
            if ($image) {
                $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
                $imageName = preg_replace('/[^a-zA-Z0-9]/', '', $request['email']);
                $imageName = $imageName . '.' . $ext;
                $image->move('admin/employee_img', $imageName);
                $data['image'] = $imageName;
            }

            // $input = $request->all();
            $employee = Employee::where('id',$id)->first();

            // $employee->update($input);
            $employee->update([
                'name'=>$request->name,
                'image'=>$imageName?? '',
                'phone'=>$request->phone,
                'dob'=>$request->dob,
                'user_id'=> $user->id?? Null,
                'f_name'=> $request->f_name,
                'm_name'=> $request->m_name,
                'nid'=> $request->nid,

                'present_address'=>$request->present_address,
                'permanent_address'=>$request->permanent_address,
                'join_date'=>$request->join_date,
                'created_by'=>Auth::user()->id,
            ]);
        }

        return redirect()->route('employee.index')
                        ->with('success','Employee Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $dependency = KnittingProductionDetail::where('employee_id', $id)->get();
        if (count($dependency) > 0) {
            return redirect()->back()
                ->with('errors', 'This data is used as next reference.');
        }
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return redirect()->route('employee.index')
        ->with('success', 'Employee deleted successfully');
    }
}
