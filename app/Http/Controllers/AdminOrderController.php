<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminOrderController extends Controller
{
    
    public function retrieveOrders(Request $request){
        // $request->session->all();
        $user = Auth::guard('admin')->user();
        $username = Auth::guard('admin')->user()->name;
        $id = Auth::guard('admin')->user()->id;
        $admin_id = Auth::guard('admin')->user()->id;

        // $no_of_orders = sum(DB::table('users')->get('orders'));
        $no_of_orders = DB::table('users')->sum('orders');
        // dd($no_of_orders);
        $order = DB::table('orders')->get();
        $orderItems = DB::table('orders')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(15);

        if(count($order) != 0){
            $order_ids = DB::table('orders')->distinct()->get('order_id');
            // dd($order_id);
            foreach ($order_ids as $order_id) {

                $order_id = $order_id->order_id;
                // dd($order_id);
                $table_id = DB::table('orders')->where('order_id', $order_id)->first()->id;
                // $table_id = DB::table('orders')->where('order_id', $order_id)->first()->id;
                // dd($table_id);
                // $order_id = DB::table('orders')->where('id', $table_id)->first()->order_id;

                $user_id = DB::table('orders')->where('id', $table_id)->first()->user_id;
                // dd($user_id);
                
                
                $email = DB::table('users')->where('id', $user_id)->first()->email;
            }
            
            
        }else{
            return view('orders.retrieve-orders',
            compact('id', 'admin_id', 'username', 'no_of_orders', 'order', 'orderItems'));
        }
        
        return view('orders.retrieve-orders',
            compact('id', 'admin_id', 'username', 'orderItems', 'no_of_orders', 'email', 'order_ids', 'order_id', 'user_id', 'table_id', 'order', 'email')
        );
    }

    public function searchOrder(Request $request){
        $user = Auth::guard('admin')->user();
        $username = Auth::guard('admin')->user()->name;
        $admin_id = Auth::guard('admin')->user()->id;

        $query = $request->get('query');
        // dd($query);
        $orderItems = DB::table('orders')->where('id', 'LIKE', '%'.$query.'%')
                           ->orWhere('user_id', 'LIKE', '%'.$query.'%')
                           ->orWhere('order_id', 'LIKE', '%'.$query.'%')
                           ->orWhere('item_id', 'LIKE', '%'.$query.'%')
                           ->orderBy('created_at', 'DESC');
        // $orderItems = DB::table('orders')->orderBy('created_at', 'DESC'); 
        $order = DB::table('orders')->get();
        $order_ids = DB::table('orders')->distinct()->get('order_id');
        // dd($order_id);
        foreach ($order_ids as $order_id) {

            $order_id = $order_id->order_id;
            // dd($order_id);
            $table_id = DB::table('orders')->where('order_id', $order_id)->first()->id;
            // $table_id = DB::table('orders')->where('order_id', $order_id)->first()->id;
            // dd($table_id);
            // $order_id = DB::table('orders')->where('id', $table_id)->first()->order_id;

            $user_id = DB::table('orders')->where('id', $table_id)->first()->user_id;
            // dd($user_id);
            
            
            $email = DB::table('users')->where('id', $user_id)->first()->email;
        }
        
        // if($request->has('query')){
        //     $orderItems = $orderItems->where('order_id', 'like', '%'.$request->get('query', '').'%');
        // }
        $no_of_orders = DB::table('users')->sum('orders');


        // $table_id = Order::where('id', 'LIKE', '%'.$validated['param'].'%')->get();
        // $user_id = Order::where('user_id', 'LIKE', '%'.$validated['param'].'%')->get();
        // $order_id = Order::where('order_id', 'LIKE', '%'.$validated['param'].'%')->get();
        // $item_id = Order::where('item_id', 'LIKE', '%'.$validated['param'].'%')->get();
        
        // return view('orders.retrieve-orders', compact('table_id', 'user_id', 'order_id', 'item_id'));
        return view('orders.retrieve-orders', ['orderItems'=>$orderItems->paginate(15)],
         compact('orderItems', 'admin_id', 'no_of_orders', 'order', 'email', 'user_id', 'table_id', 'order_id' ));

    }

    public function cancelOrder(Request $request, $order_id){
        $user = Auth::guard('admin')->user();
        $username = Auth::guard('admin')->user()->name;
        $admin_id = Auth::guard('admin')->user()->id;
        $order = Order::find($order_id);

        // $user_id = DB::table('receipts')->where('id', $receipt_id)->get('user_id');
        // $user_id = $user_id[0]->user_id;
        $user_id = DB::table('orders')->where('order_id', $order_id)->first()->user_id;
        // dd($user_id);
        $email = DB::table('users')->where('id', $user_id)->first()->email;
        // dd($email);
        $order_id = $request->input('order_id');
        $orderItems = DB::table('orders')
            ->where('order_id', $order_id)
            ->get();

        $orders = DB::table('orders')->where([
            'order_id'=> $order_id,
            'user_id' => $user_id
        ])->first();
        
            // dd($orderItems);
        $validated = $request->validate([
            'total_cost' => 'numeric|between:0.00,9999999.99'
        ]);
        $old_wallet_balance = DB::table('users')->where('id', $user_id)->first()->wallet_balance;
        $new_wallet_balance = $validated['total_cost'];
        $new_wallet_balance = (float)$new_wallet_balance;
        DB::table('users')->where('id', $user_id)
            ->update([
                'wallet_balance' => $new_wallet_balance + $old_wallet_balance,
                'updated_by' => $username,
                'updated_at' => now()
            ]);

        $old_order_status = DB::table('users')->where('id', $user_id)->first()->orders;
        $new_order_status = $old_order_status-1;

        DB::table('users')->where('id', $user_id)
            ->update([
                'orders' => $new_order_status,
                'updated_by' => $username,
                'updated_at' => now()
            ]);
        $mail_send = Mail::send("emails.users.cancel-order", [ 'email'=>$email, 'orderItems'=>$orderItems, 'order_id'=>$order_id, 
            'new_wallet_balance'=>$new_wallet_balance, 'orders'=>$orders ], function($message) use ($request){
                $message->to($request->email);
                $message->subject('Order Cancelled');
            });

        // $order_id = $order->order_id;
        // dd($order);
        if($mail_send){
            DB::table('orders')
                ->where(['order_id' => $order_id])
                ->delete();
  
        }
        return redirect()->to(route('admin.retrieve.orders'))->with('status', 'Order canceled successfully');

    }

    public function confirmDelivery(Request $request, $order_id){
        $user = Auth::guard('admin')->user();
        $username = Auth::guard('admin')->user()->name;
        $admin_id = Auth::guard('admin')->user()->id;
        $order = Order::find($order_id);

        $user_id = DB::table('orders')->where('order_id', $order_id)->first()->user_id;
        // dd($user_id);
        $email = DB::table('users')->where('id', $user_id)->first()->email;
        // dd($email);
        $order_id = $request->input('order_id');
        $orderItems = DB::table('orders')
            ->where('order_id', $order_id)
            ->get();
            // dd($orderItems);

        $orders = DB::table('orders')->where([
            'order_id'=> $order_id,
            'user_id' => $user_id
        ])->first();
        $mail_send = Mail::send("emails.users.order-confirmation", [ 'email'=>$email, 'orderItems' => $orderItems, 'order_id'=>$order_id,'orders'=>$orders], function($message) use ($request){
            $message->to($request->email);
            $message->subject('Order Delivered');
        });

        if($mail_send){
            DB::table('orders')
                ->where(['order_id' => $order_id])
                ->delete();
        }

        $old_order_status = DB::table('users')->where('id', $user_id)->first()->orders;
        $new_order_status = $old_order_status-1;

        DB::table('users')->where('id', $user_id)
            ->update([
                'orders' => $new_order_status,
                'updated_by' => $username,
                'updated_at' => now()
            ]);

        return redirect()->to(route('admin.retrieve.receipts'))->with('status', 'Order delivered successfully');
    }
}
