<?php
// <!-- app/Http/Controllers/UserController.php app/Http/Controllers/Controller.php -->
namespace App\Http\Controllers;
use id;
use Carbon\Carbon;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class ResetPasswordController extends Controller
{
    public function forgotPassword(){
            return view("password_reset.forgot-password");
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
        Mail::send("emails.forgot-password", ['token'=>$token, 'email'=>$email], function($message) use ($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return redirect()->to(route('forgot.password'))->with('success','We have sent you an email to reset password');
    }

    public function resetPassword($token){
        // $request->validate([
        //     "email"=> $request->resetemail,
        // ]);
        // $email = $request->resetemail;
        return view("password_reset.reset-password", compact("token"));
    }


    public function resetPasswordPost(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
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
            return redirect()->to(route('reset.password', ['token'=>$token]))
                ->with('error', 'Invalid token or email');
            // return redirect()->route('reset.password');
                
        }
        // #######----INITIAL SOLUTION
        User::where('email', $request->email)
            ->update([
                'password' => bcrypt($request->password)
            ]);

        DB::table('password_resets')
            ->where(['email' => $request->email])
            ->delete();

        return redirect()->to(route('login'))
            ->with('success', 'Password reset successful');
        // return redirect()->route('signin');

        // return redirect('/signin');
    }
}