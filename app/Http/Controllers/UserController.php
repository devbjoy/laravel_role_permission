<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function addToRole(string $id)
    {
        $user = User::find($id);
        if(empty($user)){
            return redirect()->route('users.index')->with('error','User Not Found');
        }
        
        $roles = Role::get();

        $data['roles'] = $roles;
        $data['user'] = $user;
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
        // return $request->all();
        // $user->name = $request->name;
        // $user->save();

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success','User Role Asigne Successfully');
    }
}
