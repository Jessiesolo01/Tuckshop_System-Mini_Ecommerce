<?php

namespace App\Http\Controllers;

use id;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function register(){
        return view("register");
    }
    public function login(){
        return view("login");
    }
    public function registerPost(Request $request){
        $incomingFields = $request->validate([
            "name"=>["required","min:2"],
            "email"=> ["required", "email", Rule::unique("users", "email")],
            "password"=> ["required","min:4", "max:250"],
        ]);
        $incomingFields["password"] = bcrypt($incomingFields["password"]);
        
        $user = User::create($incomingFields);
        auth()->login($user);

        return redirect("/dashboard");
    }
    public function loginPost(Request $request){
        
        $incomingFields = $request->validate([
            "loginemail"=>"required",
            "loginpassword"=> "required"
        ]);
        if(auth()->attempt(['email'=>$incomingFields['loginemail'], 'password'=>$incomingFields['loginpassword']])){
            $request->session()->regenerate();
            $user = Auth::user();
            return redirect("/dashboard");
        }
        else{
            return redirect("/signin");
        }
    }
    public function logout(){
        auth()->logout();
        return redirect("/");
    }
    public function dashboard(Request $request, $user){
        return view("dashboard", compact("user"));
    }
    // public function forgotPassword(){

    //     return view("forgot-password");
    // }
    
}


