<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\CompanySettings;
use DB;
use Illuminate\Support\Facades\File;

class CompanySettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $companySettings=CompanySettings::first();
        if(!empty($companySettings)){
            return view('settings::settings.index',compact('companySettings')); 
        }else{
            return view('settings::settings.create');
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('settings::settings.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'company_logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company_name' => 'required|string',
            'company_phone' => 'required|string',
            'company_email' => 'required|string',
            'company_website' => 'required',
            'address' => 'required|string',
            'copyright_text' => 'required|string', 
        ]);

        if($request->hasfile('company_logo'))
        {
            // $destination = 'admin/dist/img/settings'.$softwaresetting->company_logo;
            // if(File::exists($destination))
            // {
            //     File::unlink($destination);
            // }
            $file = $request->file('company_logo');
            $extention = $file->getClientOriginalExtension();
            $imageName = time().'.'.$extention;
            $file->move('admin/dist/img/settings', $imageName);
        }
        if($request->hasfile('invoice_logo'))
        {
            $file = $request->file('invoice_logo');
            $extention = $file->getClientOriginalExtension();
            $imageInvName = time().'.'.$extention;
            $file->move('admin/dist/img/settings', $imageInvName);
        }
        CompanySettings::create([
            'company_name'=>$request->company_name,
            'copyright_text'=>$request->copyright_text,
            'company_phone'=>$request->company_phone,
            'company_email'=>$request->company_email,
            'company_website'=>$request->company_website,
            'address'=>$request->address,
            'company_logo'=>$imageName?? '',
            'invoice_logo'=>$imageInvName?? '',
        ]);
        return redirect()->route('setting.index')
        ->with('success','Software setting updated successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('settings::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('settings::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'company_logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'company_name' => 'required|string',
            'company_phone' => 'required|string',
            'company_email' => 'required|string',
            'company_website' => 'required',
            'address' => 'required|string',
            'copyright_text' => 'required|string', 
        ]);

        if($request->hasfile('company_logo'))
        {
            // $destination = 'admin/dist/img/settings'.$softwaresetting->company_logo;
            // if(File::exists($destination))
            // {
            //     File::delete($destination);
            // }
            $file = $request->file('company_logo');
            $extention = $file->getClientOriginalExtension();
            $imageName = time().'.'.$extention;
            $file->move('admin/dist/img/settings', $imageName);
        }
        if($request->hasfile('invoice_logo'))
        {
            $file = $request->file('invoice_logo');
            $extention = $file->getClientOriginalExtension();
            $imageInvName = time().'.'.$extention;
            $file->move('admin/dist/img/settings', $imageInvName);
        }

        $companySettings = CompanySettings::findOrFail($id);
        $companySettings->update([
            'company_name'=>$request->company_name,
            'company_phone'=>$request->company_phone,
            'company_email'=>$request->company_email,
            'company_website'=>$request->company_website,
            'address'=>$request->address,
            'copyright_text'=>$request->copyright_text,
            'company_logo'=>$imageName?? $companySettings->company_logo,
            'invoice_logo'=>$imageInvName?? $companySettings->invoice_logo,
        ]);
        return redirect()->route('setting.index')
        ->with('success','Software setting updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
