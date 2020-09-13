<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Admin;
use Str;

class ApiAdminLoginController extends Controller
{
    use AuthenticatesUsers;

    public function username()
    {
        return 'email';
    }

    public function login(Request $request)
    {
        if(!$request->ajax()) { return abort(404) ;}

        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string'
        ]);

        if( auth()->guard('admin')->attempt(
        	 	$request->only( $this->username() , 'password'), 
        	 	$request->filled('remember') 
        	 ) 
           ) {
            
            $token = Str::random(10).time();
            $token = hash('sha256', $this->username().$token);
            
            $admin = auth()->guard('admin')->user();
            $admin->update(['api_token'=>$token]);

            return response()->json([
                'message'=>'OK.',
                'name'=>$admin->name,  
                'token' => $token,
                'type' => 'Bearer',
            ]);
        } 
        
        return response()->json(['message' =>'Unauthenticated.'], 401); 

    }
    
    public function logout(Request $request)
    {
        $auth = auth()->guard('apiadmin');
        $auth->user()->update(['api_token'=>'']);
        return response()->json(['message' =>'OK.']); 
    }
}
