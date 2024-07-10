<?php
namespace App\Http\Controllers;
use id;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AdminResetPasswordController extends Controller
{
    public function forgotPassword(){
            return view("admin_password_reset.forgot-password");
        }

    public function forgotPasswordPost(Request $request){
        $request->validate([
            'email'=>'required|email',
        ]);
        $email = $request->email;
        $token = Str::random(64);
        
        DB::table('password_resets')->insert([
            "email"=>$email,
            "token"=>$token,
            "created_at"=>Carbon::now(),
        ]);
        Mail::send("emails.admins.forgot-password", ['token'=>$token, 'email'=>$email], function($message) use ($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return redirect()->to(route('admin.forgot.password'))->with('success','We have sent you an email to reset password');
    }

    public function resetPassword(Request $request, $token){
        // $request->validate([
        //     "email"=> $request->email,
        // ]);
        $email = DB::table('password_resets')
        ->where('token', $token)
        ->first()->email;

        return view("admin_password_reset.reset-password", compact("token", "email"));
    }


    public function resetPasswordPost(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:admins,email',
            // 'email' => 'required|email',
            'password' => 'required|min:4|max:200|confirmed',
            'password_confirmation' => 'required'
        ]);
// };
        $token = $request->token;

        // dd($request->all());
        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
                // 'token' => $token
            ])
            ->first();
            // dd($updatePassword);
        
        if (!$updatePassword) {
            return redirect()->to(route('admin.reset.password', ['token'=>$token]))
                ->with('error', 'Invalid token or email');
            // return redirect()->route('reset.password');
                
        }
        // #######----INITIAL SOLUTION
        
        Admin::where('email', $request->email)
            ->update([
                'password' => bcrypt($request->password)
            ]);

// #####THIS SECOND SOLUTION WORKS AS WELL
        // DB::table('admins')
        //     ->where(['email' => $request->email])
        //     ->update([
        //         'password'=> bcrypt($request->password)
        //     ]);
                // dd($request->all());

            // if(!$userUpdate){
            //     Admin::where('email', $request->email)
            //     ->update([
            //         'password' => bcrypt($request->password)
            //     ]);
            // }
        // if(!$userUpdate){
        //     DB::table('admins')
        //     ->where(['email' => $request->email])
        //     ->update([
        //         'password'=> bcrypt($request->password)
        //     ]);
        // }
        DB::table('password_resets')
            ->where(['email' => $request->email])
            ->delete();

        return redirect()->to(route('admin.login'))
            ->with('success', 'Password reset successful');
        // return redirect()->route('signin');

        // return redirect('/signin');
    }
}