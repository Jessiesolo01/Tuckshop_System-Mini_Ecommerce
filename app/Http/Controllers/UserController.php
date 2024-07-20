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
use Illuminate\Support\Facades\DB;
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
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|min:4|max:250|confirmed',
            'password_confirmation'=> 'required'
        ]);
        // dd($request->all());
        $validated['password'] = bcrypt($validated['password']);    
        $user = User::create($validated);
        auth()->login($user);
        $id =$user->id;
        // return redirect('/dashboard/{id}');
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
    public function dashboard(Request $request){
        $username = Auth::user()->name;
        // $id =Auth::user()->id;

        // return view("users.dashboard", compact('username','id'));
        return view("users.dashboard", compact('username'));

    }
    public function editUser(Request $request, $id){//the id here is the param from the url(/edit-item/{id})
        if (Auth::guard('admin')->check()){
            // $request->session()->all();
            $username = Auth::guard('admin')->user()->username;
            $user = User::find($id);//the id is the one in the function param, this finds an item with this id        
            return view('admins.edit-user', compact('username', 'user'));
        }
        else{
            return redirect('/')->with('error', 'Unauthorized access');
        }
    }
    public function updateUser(Request $request, $id){
        $request->session()->all();
        $username = Auth::guard('admin')->user()->username;
        $admin_id =Auth::guard('admin')->user()->id;

        $user = User::find($id);
        $id = $user->id;
        $validated = $request->validate([
            'name'=> 'string',
            'email' => 'string|email|unique:users,email',
            // 'wallet_balance' => 'numeric|between:0.00,9999999.99',
            'orders' => 'digits_between:0,9',
            'updated_by' => 'required',
            // 'updated_at' => 'required'
        ]);
        User::where('id', $user->id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                // 'wallet_balance' => $request->wallet_balance,
                'orders' => $request->orders,
                'updated_by' => $request->updated_by,
                // 'updated_at'=>Carbon::now(),
                // 'updated_at' => $request->updated_at
            ]);
        return redirect()->to(route('admin.dashboard', [$admin_id]))->with('status', 'User updated successfully');

    }

    // public function updateUser(Request $request, $id){
    //    // auth()->guard('admin')->user();
    //    $request->session()->all();
    //    $username = Auth::guard('admin')->user()->username;
    //    $admin_id =Auth::guard('admin')->user()->id;

    //    $user = User::find($id);
    //    $id = $user->id;
    //    $validated = $request->validate([
    //         'name'=> 'string',
    //         'email' => 'string',
    //         // 'wallet_balance' => 'numeric|between:0.00,9999999.99',
    //         'orders' => 'digits_between:0,9',
    //         'updated_by' => 'required',
    //         // 'updated_at' => 'required'
    //    ]);

    //    // $model = Item::find($id);
    //    $user->name = $request->input('name');
    //    $user->email = $request->email;
    //    $user->orders = $request->input('orders');
    //    $user->updated_by = $request->input('updated_by');
    //    // $user->created_by = $request->input('created_by');
    // //    $user->updated_by = $request->input('updated_by');

    //    $user->save();
    //     return redirect()->to(route('admin.dashboard', [$admin_id]))->with('status', 'User updated successfully');

    // }
    public function showUser(Request $request, User $user){
        return view('admins.show-users', [
            'users' => DB::table('users')->paginate(15)
        ]);
    }
    public function deleteUser(Request $request, $id){
        // auth()->guard('admin')->user();
        $request->session()->all();
        $username = Auth::guard('admin')->user()->username;
        $admin_id =Auth::guard('admin')->user()->id;
        $user = User::find($id);
        $id = $user->id;
        DB::table('users')
            ->where(['id' => $id])
            ->delete();
        return redirect()->to(route('admin.dashboard', [$admin_id]))->with('status', 'User deleted successfully');
    }
    
}


