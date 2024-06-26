<?php
// <!-- app/Http/Controllers/UserController.php app/Http/Controllers/Controller.php -->
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
            return view("forgot-password");
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
        return view("reset-password", compact("token"));
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
        $updatePassword = DB::table('password_reset')
            ->where([
                'email' => $request->resetpassword_email,
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
        User::where('email', $request->resetpassword_email)
            ->update([
                'password' => bcrypt($request->resetpassword)
            ]);

        // #############NO 1 SOLUTION
        // $updateUser = User::where('email', $request->resetpassword_email)
        // $updateUser->save();
        ///

        // ###########NO 2 SOLUTION
        // DB::table('users')
        //     ->where(['email'=>$request->resetpassword_email])
        //     ->update(['password' => bcrypt($request->resetpassword)]);
        
        // ###########NO 3 SOLUTION
        // User::update(['password'=>bcrypt($request->resetpassword)])::where('email', $request->resetpassword_email)->first();
        
        // #############NO 4 SOLUTION
        // $updateUserPassword = User::where('email', $request->resetpassword_email);
        // $newPassword = bcrypt($request->resetpassword);
        // $updateUserPassword->password = $request->input($newPassword);
        // $updateUserPassword->save();

        // #############NO 5 SOLUTION
        // $user->update([$user->password = bcrypt($data['resetpassword'])]);
        // 
        // $user->update([$user['password'] => bcrypt($data['resetpassword'])]);

        DB::table('password_reset')
            ->where(['email' => $request->resetpassword_email])
            ->delete();

        return redirect()->to(route('signin'))
            ->with('success', 'Password reset successful');
        // return redirect()->route('signin');

        // return redirect('/signin');
    }
}