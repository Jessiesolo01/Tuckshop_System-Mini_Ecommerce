<?php

namespace App\Http\Controllers;
use id;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        return view("users.register");
    }
    public function login(){
        return view("users.login");
    }
    public function registerPost(Request $request){
        $validated = $request->validate([
            'name'=>'required|min:2',
            'email'=> 'required|email|exists:users,email',
            'password'=> 'required|min:4|max:250|confirmed',
            'password_confirmation'=> 'required'
        ]);
        // dd($request->all());
        $validated["password"] = bcrypt($validated["password"]);    
        $user = User::create($validated);
        $id =$user->id;
        auth()->login($user);
        return redirect()->to(route('dashboard', [$id]));
    }
    public function loginPost(Request $request){
        
        $validated = $request->validate([
            "email"=>"required",
            "password"=> "required"
        ]);
        if(auth()->attempt(['email'=>$validated['email'], 'password'=>$validated['password']])){
            $request->session()->regenerate();
            $user = Auth::user();
            $id = $user->id;

            return redirect()->to(route('dashboard', [$id]));
        }
        else{
            return redirect()->to(route('login'));

        }
    }
    public function logout(){
        auth()->logout();
        return redirect("/");
    }
    public function dashboard(Request $request, $username){
        $username = Auth::user()->name;
        return view("users.dashboard", compact("username"));
    }
    // public function forgotPassword(){

    //     return view("forgot-password");
    // }
    
}


