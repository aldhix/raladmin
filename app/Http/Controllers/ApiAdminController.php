<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;

class ApiAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Admin::
                select('id','name','email')
                ->orderBy('id','asc')
                ->get();

        return response()->json(['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
                'name'=>'required|string|min:3',
                'email'=>'required|email|min:3|unique:admins,email',
                'password'=>'required|min:6|confirmed'
            ]);

        $result = Admin::create( $request->only(['name','email','password']) );

        return  $result 
                ? response()->json(['message'=>'OK.'])
                : response()->json(['message'=>'Unprocessable Entity.'], 422);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        return response()->json([
                'data'=>$admin->only(['id','name','email'])
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
                'name'=>'required|string|min:3',
                'email'=>'required|email|min:3|unique:admins,email,'.$admin->id,
                'password'=>'nullable|min:6|confirmed'
            ]);

        $query =  !empty( $request->password )
                   ? $request->only(['name','email','password'])
                   : $request->only(['name','email']);
        
        $result = $admin->update( $query );

        return  $result 
                ? response()->json(['message'=>'OK.'])
                : response()->json(['message'=>'Unprocessable Entity.'], 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
       $result = $admin->delete();

       return  $result 
                ? response()->json(['message'=>'OK.'])
                : response()->json(['message'=>'Unprocessable Entity.'], 422); 
    }

    public function profile(Request $request)
    {
        return $request->user()->only(['id','name','email']);
    }

    public function updateProfile(Request $request)
    {
        $admin = $request->user();

        $request->validate([
                'name'=>'required|string|min:3',
                'email'=>'required|email|min:3|unique:admins,email,'.$admin->id,
                'password'=>'nullable|min:6|confirmed'
            ]);

        $query =  !empty( $request->password )
                   ? $request->only(['name','email','password'])
                   : $request->only(['name','email']);
        
        $result = $admin->update( $query );

        return  $result 
                ? response()->json(['message'=>'OK.'])
                : response()->json(['message'=>'Unprocessable Entity.'], 422);
    }
}
