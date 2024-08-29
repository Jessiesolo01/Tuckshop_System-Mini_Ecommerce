<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function updateWallet(Request $request, $id){
        // $request->session->all();
        $user = Auth::user();
        $username = Auth::user()->name;
        $id = Auth::id();
        $user_id = Auth::id();
        $wallet_balance = DB::table('users')->where('id', $user_id)->first()->wallet_balance;

        $receipts = DB::table('receipts')->where('user_id', $id)
                ->get();
        $no_of_receipts = count($receipts);
                // dd($receipt);
        return view('receipts.update_wallet', compact('id', 'username', 'receipts', 'no_of_receipts', 'wallet_balance'));
    }

    public function updateWalletPost(Request $request, $id){
        $user = Auth::user();
        $username = Auth::user()->name;
        $id = Auth::id();
        $user_id = Auth::id();
        $validated = $request->validate([
            'file' => 'required|file|mimes:png,jpg,jpeg,svg,webp,gif,pdf'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('receipt_uploads', $fileName, 'public');
        }
        $receipt = new Receipt();
        $receipt->user_name = $request->input('user_name');
        $receipt->file = $filePath;
        $receipt->user_id = $request->input('id');
        $receipt->uploaded_by = $request->input('user_name');
        $receipt->updated_by = $request->input('user_name');
        $receipt->save();

        return redirect()->to(route('dashboard', [$id]))->with('status', 'Receipt uploaded successfully');
    }
    public function viewReceipt(Request $request, $receipt_id){
        $user = Auth::user();
        $username = Auth::user()->name;
        $user_id = Auth::id();

        $receipt = Receipt::find($receipt_id);
        // dd($receipt);
        $receipt_id = $receipt->id;
        // dd($receipt_id);
        $receipt_file =  DB::table('receipts')
        ->where(['id' => $receipt_id])
        ->first()->file;
        // $receipt_path= $request->$receipt->id;
        return view('receipts.view-receipts', compact('receipt_file'));
        // return view('show', ['img' => $img]);
    }

    public function deleteReceipt(Request $request, $receipt_id){
        $user = Auth::user();
        $username = Auth::user()->name;
        $user_id = Auth::id();
        // $receipt_id = DB::table('receipts')->where('id',);

        $receipt = Receipt::find($receipt_id);
        // dd($receipt);
        $receipt_id = $receipt->id;

        DB::table('receipts')
            ->where(['id' => $receipt_id])
            ->delete();
        return redirect()->to(route('dashboard', [$user_id]))->with('status', 'Receipt deleted successfully');

    }
}
