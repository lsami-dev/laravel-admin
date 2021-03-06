<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => 'required|string|max:191',
            "email" => 'required|string|email|max:191|unique:users',
            "password" => 'required|string|min:8',
            "role" => 'required'
        ]);

        return User::create(
            [
                'name'=> $request['name'],
                'email'=> $request['email'],
                'password'=> Hash::make($request['password']),
                'role'=> $request['role'],
            ]
        );
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrfail($id);
        $this->validate($request, [
            "name" => 'required|string|max:191',
            "email" => 'required|string|email|max:191|unique:users,email,'.$user->id,
            "password" => 'required|string|min:8',
            "role" => 'required'
        ]);
        $user->update($request->all());

        
        return ['message' => 'Updated User Info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return ['message' => 'User deleted !'];
    }

    public function profile()
    {
        return auth('api')->user();
    }
}
