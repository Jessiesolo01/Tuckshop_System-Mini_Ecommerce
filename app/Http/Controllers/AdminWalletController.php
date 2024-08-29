<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminWalletController extends Controller
{
    public function retrieveReceipts(Request $request){
        // $request->session->all();
        $user = Auth::guard('admin')->user();
        $username = Auth::guard('admin')->user()->name;
        $id = Auth::guard('admin')->user()->id;
        $admin_id = Auth::guard('admin')->user()->id;

        $no_of_receipts = count(DB::table('receipts')->get());
        $receipts = DB::table('receipts')->paginate(15);
        if(count($receipts) != 0){
            $receipt_id = DB::table('receipts')->first()->id;
            $user_id = DB::table('receipts')->where('id', $receipt_id)->first()->user_id;
    
            $email = DB::table('users')->where('id', $user_id)->first()->email;
        }else{
            return view('receipts.retrieve-receipts',
            compact('id', 'admin_id', 'username', 'no_of_receipts'));
        }
        
        
        // $receipt_id = $request->input('user_id');
        // $user_id = $request->input('user_id');

        // $user_id = DB::table('receipts')->where('id', $request->receipt_id)->get('user_id');
        return view('receipts.retrieve-receipts',
            compact('id', 'admin_id', 'username', 'receipts', 'no_of_receipts', 'email', 'receipt_id')
        );
        // $receipts = DB::table('receipts')->get();
        // $no_of_receipts = count($receipts);
        //         // dd($receipt);
        // return view('receipts.retrieve-receipts', compact('id', 'username', 'receipts', 'no_of_receipts'));
    }

    public function searchReceipt(Request $request){
        $user = Auth::guard('admin')->user();
        $username = Auth::guard('admin')->user()->name;
        $admin_id = Auth::guard('admin')->user()->id;

        $query = $request->get('query');
        // dd($query);
        $receipts = DB::table('receipts')->where('id', 'LIKE', '%'.$query.'%')
                           ->orWhere('user_id', 'LIKE', '%'.$query.'%')
                           ->orWhere('user_name', 'LIKE', '%'.$query.'%')
                           ->orWhere('uploaded_by', 'LIKE', '%'.$query.'%')
                           ->orWhere('updated_by', 'LIKE', '%'.$query.'%')
                           ->orWhere('created_at', 'LIKE', '%'.$query.'%')
                           ->orWhere('updated_at', 'LIKE', '%'.$query.'%')
                           ->orderBy('created_at', 'ASC');
      
        $no_of_receipts = count(DB::table('receipts')->get());
        $receipt_id = DB::table('receipts')->first()->id;
        $user_id = DB::table('receipts')->where('id', $receipt_id)->first()->user_id;

        $email = DB::table('users')->where('id', $user_id)->first()->email;

        return view('receipts.retrieve-receipts', ['receipts'=>$receipts->paginate(15)],
         compact('admin_id', 'username', 'no_of_receipts', 'email'));

    }
    public function viewReceipt(Request $request, $receipt_id){
        $user = Auth::guard('admin')->user();
        $username = Auth::guard('admin')->user()->name;
        $admin_id = Auth::guard('admin')->user()->id;

        $receipt = Receipt::find($receipt_id);
        $receipt_id = $receipt->id;
        $receipt_file =  DB::table('receipts')
            ->where(['id' => $receipt_id])
            ->first()->file;
        return view('receipts.view-receipts', compact('receipt_file'));
    }

    public function cancelReceipt(Request $request, $receipt_id){
        $user = Auth::guard('admin')->user();
        $username = Auth::guard('admin')->user()->name;
        $admin_id = Auth::guard('admin')->user()->id;
        $receipt = Receipt::find($receipt_id);

        // $user_id = DB::table('receipts')->where('id', $receipt_id)->get('user_id');
        // $user_id = $user_id[0]->user_id;
        $user_id = DB::table('receipts')->where('id', $receipt_id)->first()->user_id;
        // dd($user_id);
        $email = DB::table('users')->where('id', $user_id)->first()->email;
        // dd($email);

        $mail_send = Mail::send("emails.users.upload-receipt", [ 'email'=>$email], function($message) use ($request){
            $message->to($request->email);
            $message->subject('Upload a Valid Receipt');
        });

        $receipt_id = $receipt->id;
        if($mail_send){
            DB::table('receipts')
                ->where(['id' => $receipt_id])
                ->delete();
  
        }
        return redirect()->to(route('admin.retrieve.receipts'))->with('status', 'Receipt canceled successfully');

    }

    public function confirmReceipt(Request $request, $receipt_id){
        $user = Auth::guard('admin')->user();
        $username = Auth::guard('admin')->user()->username;
        $admin_id = Auth::guard('admin')->user()->id;
        $receipt = Receipt::find($receipt_id);

        // $user_id = DB::table('receipts')->where('id', $receipt_id)->get('user_id');
        // $user_id = $user_id[0]->user_id;
        $user_id = DB::table('receipts')->where('id', $receipt_id)->first()->user_id;
        // dd($user_id);
        $email = DB::table('users')->where('id', $user_id)->first()->email;
        // dd($email);

        $validated = $request->validate([
            'new_wallet_balance' => 'numeric|between:0.00,9999999.99'
        ]);
        $old_wallet_balance = DB::table('users')->where('id', $user_id)->first()->wallet_balance;
        $new_wallet_balance = $validated['new_wallet_balance'];
        $new_wallet_balance = (float)$new_wallet_balance;
        DB::table('users')->where('id', $user_id)
            ->update([
                'wallet_balance' => $new_wallet_balance + $old_wallet_balance,
                'updated_by' => $username,
                'updated_at' => now()
            ]);

        $mail_send = Mail::send("emails.users.receipt-confirmation", [ 'email'=>$email, 'new_wallet_balance' => $new_wallet_balance], function($message) use ($request){
            $message->to($request->email);
            $message->subject('Receipt Confirmation');
        });

        $receipt_id = $receipt->id;
        if($mail_send){
            DB::table('receipts')
                ->where(['id' => $receipt_id])
                ->delete();
  
        }

        return redirect()->to(route('admin.retrieve.receipts'))->with('status', 'Receipt confirmed successfully');
    }
}
