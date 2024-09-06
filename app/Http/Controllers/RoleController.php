<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view role',only:['index']),
            new Middleware('permission:edit role',only:['edit']),
            new Middleware('permission:create role',only:['create']),
            new Middleware('permission:delete role',only:['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('created_at')->paginate(10);
        return view('roles.index',['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permission = Permission::get();

        return view('roles.create',['permissions' => $permission]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(),[
        'name' => 'required|unique:roles'
       ]);

       if($validator->fails()){
        return redirect()->route('roles.create')->withInput()->withErrors($validator);
       }

       $role = new Role();
       $role->name = $request->name;
       $role->save();

       if(!empty($request->permission)){
        $role->syncPermissions($request->permission);
       }

       return redirect()->route('roles.index')->with('success','This role permission added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::find($id);

        if(empty($role)){
            return redirect()->route('roles.index')->with('error','Role not Found !');
        }

        $hasPermission = $role->permissions->pluck('name');
       
        $permission = Permission::get();
       
        $data['role'] = $role;
        $data['permissions'] = $permission;
        $data['hasPermission'] = $hasPermission;
        return view('roles.edit',$data);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::find($id);

        if(empty($role)){
            return redirect()->route('roles.index')->with('error','Role not Found !');
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:roles,name,'.$id.',id',
        ]);
    
        if($validator->fails()){
            return redirect()->route('roles.edit',$id)->withInput()->withErrors($validator);
        }

        $role->name = $request->name;
        $role->save();

        if(!empty($request->permission)){
            $role->syncPermissions($request->permission);
        }

        return redirect()->route('roles.index')->with('success','This role permission updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);

        if(empty($role)){
            return redirect()->route('roles.index')->with('error','Role not Found !');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('error','This role Deleted successfully');
    }
}
