<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Unique;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view users',only:['index']),
            new Middleware('permission:edit users',only:['edit']),
            new Middleware('permission:create users',only:['create']),
            new Middleware('permission:delete users',only: ['destroy']),
            new Middleware('permission:add to role users',only: ['addToRole']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('id','desc')->paginate(10);
        return view('users.index',['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return redirect()->route('users.create')->withInput()->withErrors($validator);
        }

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        return redirect()->route('users.index')->with('success','User Create Successfully');
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
        $user = User::find($id);
        if($user == null){
            return redirect()->route('users.index')->with('error','User not found !');
        }
        return view('users.edit',['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if($user == null){
            return redirect()->route('users.index')->with('error','User not found !');
        }
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3|string',
            'email' => 'required|email|unique:users,email,'.$id.',id'
        ]);

        if($validator->fails()){
            return redirect()->route('users.edit',$id)->withInput()->withErrors($validator);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if($request->password != null){
            $data += [
                'password' => Hash::make($request->password)
            ];
        }else{
            $data += [
                'password' => $user->password
            ];
        }
        $user->update($data);

        return redirect()->route('users.index')->with('success','User update successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if($user == null){
            return redirect()->route('users.index')->with('error','user not found !');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success','User deleted successfully');
    }

    public function addToRole(string $id)
    {
        $user = User::find($id);
        if(empty($user)){
            return redirect()->route('users.index')->with('error','User Not Found');
        }
        $hasRoles = $user->getRoleNames();
        $roles = Role::get();

        $data['roles'] = $roles;
        $data['user'] = $user;
        $data['hasRoles'] = $hasRoles;
        return view('users.add-role',$data);
    }

    public function addToRoleProcess(Request $request, string $id)
    {
        $user = User::find($id);
        
        if(empty($user)){
            return redirect()->route('users.index')->with('error','User Not Found');
        }
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3|string'
        ]);

        if($validator->fails()){
            return redirect()->route('users.user.addToRole',$id)->withInput()->withErrors($validator);
        }
    
        $user->syncRoles($request->role);
        return redirect()->route('users.index')->with('success','User Role Asigne Successfully');
    }
}
