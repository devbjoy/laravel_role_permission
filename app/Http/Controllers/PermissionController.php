<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::orderBy('created_at','asc')->paginate(10);
        $data['permissions'] = $permissions;
        return view('permissions.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:permissions|min:3'
        ]);

        if($validator->fails()){
            return redirect()->route('permission.create')->withInput()->withErrors($validator);
        }else{

            Permission::create([
                'name' => $request->name
            ]);
            // $permission = new Permission();
            // $permission->name = $request->name;
            // $permission->save();
            
            return redirect()->route('permission.index')->with('success','Permission Added Successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permission = Permission::find($id);

        if(empty($permission)){
            return redirect()->route('permission.index')->with('error','permission not found !');
        }

        return view('permissions.edit',['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $permission = Permission::find($id);

        if(empty($permission)){
            return redirect()->route('permission.index')->with('error','Permission not found !');
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:permissions,name,'.$id.',id'
        ]);

        if($validator->fails()){
            return redirect()->route('permission.edit',$id)->withInput()->withErrors($validator);
        }else{

            $permission->name = $request->name;
            $permission->save();
            
            return redirect()->route('permission.index')->with('success','Permission Updated Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::find($id);

        if(empty($permission)){
            return redirect()->route('permission.index')->with('error','Permission item not found !');
        }

        $permission->delete();

        return redirect()->route('permission.index')->with('error','Permission Item Deleted Successfully');
    }
}
