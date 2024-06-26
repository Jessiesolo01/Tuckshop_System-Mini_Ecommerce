<?php

namespace App\Http\Controllers;
use id;
use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    public function login(){
        return view("admins.login");
    }
    public function loginPost(Request $request){
        
        $validated = $request->validate([
            "username"=>"required",
            "password"=> "required"
        ]);
        if(auth()->attempt(['email'=>$validated['email'], 'password'=>$validated['password']])){
            $request->session()->regenerate();
            $user = Auth::user();
            $id = $user->id;

            return redirect()->to(route('admin.dashboard', [$id]));
        }
        else{
            return redirect()->to(route('admin.login'));

        }
    }
    public function logout(){
        auth()->logout();
        return redirect("/");
    }
    public function dashboard(Request $request){
        $username = Auth::user()->name;
        $id =$username->id;

        return view("admins.dashboard", compact('username','id'));
    }
    // public function forgotPassword(){

    //     return view("forgot-password");
    // }
    
}


