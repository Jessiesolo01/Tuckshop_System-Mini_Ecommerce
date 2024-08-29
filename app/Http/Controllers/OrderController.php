<?php

namespace App\Http\Controllers;

use DOMDocument;
use App\Models\Cart;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Rules\CustomValidationRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Stevebauman\Hypertext\Transformer;
// use Illuminate\Support\Facades\Session;
// use Symfony\Component\HttpFoundation\Session\Session;
// use App\Services\SerializableDOMDocument;


class OrderController extends Controller
{
    public function createOrder(Request $request){
        $request->session()->all();
        $username = Auth::user()->name;
        $id = Auth::id();
        // $items = DB::table('items')->get();
        $items = DB::table('items')->paginate(30);

        // $value = $request->input('quantity');
        return view('users.place-order', compact('username', 'items', 'id'));
    }

    public function placeOrder(Request $request){
        $request->session()->all();
        $username = Auth::user()->name;
        $id = Auth::id();
        $user_id = Auth::id();
        $orderItems = DB::table('cart')->where('user_id', $user_id)->get();

        $wallet_balance =  DB::table('users')->where('id', $user_id)->get('wallet_balance');
        $wallet_balance = $wallet_balance[0]->wallet_balance;
        // $wallet_balance = (int)$wallet_balance;
        // dd($wallet_balance);        

        // $item_id = DB::table('cart')->get('item_id');
        // dd($item_id);
        $cart_id = DB::table('cart')->get('id');
        // $item_id = $request->input('item_id');
        // $item = DB::table('items')
        //     ->where('id', $item_id)
        //     ->get();
        $total_quantity_of_items = 0;
        $no_of_items_ordered = count($orderItems);
        for ($i=0; $i < $no_of_items_ordered; $i++) { 
            $total_quantity_of_items += $orderItems[$i]->quantity;
        }

        $total_amount_in_naira = 0.00;

        for ($i=0; $i < $no_of_items_ordered; $i++) { 
            $quantity_of_each_item = $orderItems[$i]->quantity;
            $price = $orderItems[$i]->price;
            $items_cost = $quantity_of_each_item * (float)$price;
            $total_amount_in_naira += $items_cost;
            // $total_amount_in_naira = (float)$total_amount_in_naira;
        }

        
        // dd($orderItems);
        return view ('users.place-order-now', compact('username', 'orderItems', 'id', 'no_of_items_ordered',
         'total_quantity_of_items', 'items_cost', 'total_amount_in_naira', 'wallet_balance'));
    }
    
    public function placeOrderPost(Request $request){
        $user = Auth::user();
        $username = Auth::user()->name;
        $id = Auth::id();
        $user_id = Auth::id();


        $orderItems = DB::table('cart')->where('user_id', $user_id)->get();
        // dd($orderItems);
        $wallet_balance =  DB::table('users')->where('id', $user_id)->get('wallet_balance');
        $wallet_balance = $wallet_balance[0]->wallet_balance;
        
        $cart_id = DB::table('cart')->get('id');
        
        // $pdf = Pdf::loadHTML('pdfs.order_details');

        
        $total_quantity_of_items = 0;
        $no_of_items_ordered = count($orderItems);
        for ($i=0; $i < $no_of_items_ordered; $i++) { 
            $total_quantity_of_items += $orderItems[$i]->quantity;
        }

        $total_amount_in_naira = 0.00;

        for ($i=0; $i < $no_of_items_ordered; $i++) { 
            $quantity_of_each_item = $orderItems[$i]->quantity;
            $price = $orderItems[$i]->price;
            $items_cost = $quantity_of_each_item * (float)$price;
            $total_amount_in_naira += $items_cost;
            // $total_amount_in_naira = (float)$total_amount_in_naira;
        }

        $order_id = random_int(10308000, 99999999);
        // dd($randomNumber);
        // dd(hexdec(uniqid()));

        
        $id_exists = DB::table('orders')->where('id', $order_id)->first();
        // dd($id_exists);
        while ($id_exists != null) {
            $order_id = random_int(10308000, 99999999);
        }
        
        // foreach($orderItems as $orderItem){
            

        // }

        for ($i=0; $i < $no_of_items_ordered; $i++) { 
            $order = new Order;

            $order->order_id = $order_id;
            $order->user_id = $request->input('id');
            $order->order_owner = $username;
            $order->no_of_all_items_ordered = $no_of_items_ordered;
            $order->total_qty_of_all_items_ordered = $total_quantity_of_items;
            $order->total_amt_of_all_order_items_in_naira = $total_amount_in_naira;
            $order->item_id = $orderItems[$i]->item_id;
            $order->item_name = $orderItems[$i]->item_name;
            $order->image = $orderItems[$i]->image;
            $order->price = $orderItems[$i]->price;
            $order->quantity = $orderItems[$i]->quantity;
            $order->save();
        }
        // $order->save();

        

        // $data = [
        //     "user_id" =>$user_id,
        //     "title" => "Order Details",
        //     "date_time" => now(),
        //     // "date" => date('m/d/Y'),
        //     "no_of_items_ordered" => $no_of_items_ordered,
        //     "total_quantity_of_items" => $total_quantity_of_items,
        //     "total_amount_in_naira" => $total_amount_in_naira,
        //     "orderItems" => $orderItems,
        //     "order_id" => $order_id
        //     // "price" => $price,
        //     // "items_cost" => $items_cost,
        //     // "total_amount_in_naira" => $total_amount_in_naira
        // ];

        // $title = 'Order Details';
        // $date_time = now();

        $existing_order = DB::table('users')->where('id', $id)->get('orders');
        $existing_order = $existing_order[0]->orders; 
        // dd($existing_order);
        

    //     $pdf = Pdf::loadView('pdfs.order_details2', $data);
    //     // session('pdf', $pdf);
    //     // dd($order_details);

    //     // USING SMALOT PDFPARSER
    //     // $parser = new \Smalot\PdfParser\Parser();
    //     // $parsed_file = $parser->parseFile($pdf);
    //     // $order_details = $parsed_file->getText();

    //     // USING HTML TO STRING
    //     $view = (string)View::make('pdfs.order_details',$data);
    //     // dd($view);
        
    //    $transformer = new Transformer();
    //    $transformer->keepLinks();
    //    $transformer->keepNewLines();
    //    $order_details = $transformer->toText($view);
    // //    dd($order_details);


        // $order->order_details = $order_details;
        // $order->save();

        $new_order = (int)$existing_order+1;

        // dd($new_order);
        DB::table('users')->where('id', $id)
                ->update([
                    'wallet_balance' => $wallet_balance - $total_amount_in_naira,
                    'updated_at' => now(), 
                    'updated_by' => $username,
                    'orders' => $new_order
                ]);
        DB::table('cart')->where('user_id', $user_id)
                ->delete();
            
        // return view('users.checkout', compact('wallet_balanace'));
        // return redirect('/checkout/'.$id)->with(compact('pdf', 'id'));

        // redirect()->route('order.details', [$id])
        //     ->with(compact('id', 'user_id', 'title', 'date_time', 'no_of_items_ordered', 
        //     'total_quantity_of_items', 'total_amount_in_naira', 'orderItems', 'order_id', 'pdf'));
            // return redirect('/checkout/'.$id, ['pdf', $pdf]);

            // session(['pdf' => $pdf]);
            // return $this->generateInvoice($request);

            return redirect('/order-details/'.$id);

        // return $pdf->download('order_details.pdf');
    }

    public function checkout(Request $request, $id){
        $request->session()->all();
        session()->regenerate();
        $user = Auth::user();
        $username = Auth::user()->name;
        $id = Auth::id();
        $user_id = Auth::id();
        
        return view('users.checkout', compact('id'));

        // return view('users.checkout', ['pdf', $pdf]);
    }

    public function orderDetails(Request $request, $id){
        // $request->session()->all();
        // $request->session()->reflash();
        // session()->regenerate();
        // $data = placeOrderPost($request)->data;
        $user = Auth::user();
        $username = Auth::user()->name;
        $id = Auth::id();
        $user_id = Auth::id();

        // $order_id = DB::table('orders')->where('user_id', $user_id)->first()->order_id;

        $order_ids = DB::table('orders')->where('user_id', $user_id)->distinct()->get('order_id');
        // dd($order_ids);
        // $orderItems = DB::table('orders')->where([
        //     'order_id'=> $order_id,
        //     'user_id' => $user_id
        // ])->get();
        // // // dd($orderItems);
        // // $orders = DB::table('orders')->where([
        // //     'order_id'=> $order_id,
        // //     'user_id' => $user_id
        // // ])->first();
        // // dd($orders);
        $order_items_no = count($order_ids);
        // for($i = 0; $i < $order_items_no; $i++){
        //     $order
        // }
        // dd($data['title']);

        return view('users.order_details', compact('id', 'user_id', 'order_ids', 'username', 'order_items_no'));

        // return view('users.order_details', compact('id', 'user_id', 'order_ids', 'orders', 'username', 'orderItems', 'order_items_no'));
        // return view('users.order_details', compact('id', 'user_id', 'title', 'date_time', 'no_of_items_ordered', 
        //     'total_quantity_of_items', 'total_amount_in_naira', 'orderItems', 'order_id'));//, 'pdf'
    }
    public function orderDetailsPerOrder(Request $request, $order_id){
        // $request->session()->all();
        // $request->session()->reflash();
        // session()->regenerate();
        // $data = placeOrderPost($request)->data;
        $user = Auth::user();
        $username = Auth::user()->name;
        $id = Auth::id();
        $user_id = Auth::id();

        $order_ids = DB::table('orders')->where('user_id', $user_id)->distinct()->get('order_id');
        
        // dd($orders);
        foreach ($order_ids as $order_id) {
            $order_id = $request->input('order_id');

            $orderItems = DB::table('orders')->where([
                'order_id'=> $order_id,
                'user_id' => $user_id
            ])->get();
            // dd($orderItems);
            $orders = DB::table('orders')->where([
                'order_id'=> $order_id,
                'user_id' => $user_id
            ])->first();
            $order_items_no = count($orderItems);
            return view('users.order_details_per_order', compact('id', 'user_id', 'order_ids', 'order_id', 'orders', 'username', 'orderItems', 'order_items_no'));

        }

        // $order_id = DB::table('orders')->where('user_id', $user_id)->first()->order_id;

        // $order_ids = DB::table('orders')->where('user_id', $user_id)->get('order_id');
        // dd($order_ids);
        
        // dd($data['title']);
        // return view('users.order_details', compact('id', 'user_id', 'title', 'date_time', 'no_of_items_ordered', 
        //     'total_quantity_of_items', 'total_amount_in_naira', 'orderItems', 'order_id'));//, 'pdf'
    }

    public function generateInvoice(Request $request, $order_id){
        $user = Auth::user();
        $username = Auth::user()->name;
        $id = Auth::id();
        $user_id = Auth::id();

        $order_id = $request->input('order_id');
        // $order_id = DB::table('orders')->where('user_id', $user_id)->first()->order_id;

        // dd($order_id);
        $orderItems = DB::table('orders')->where([
            'order_id'=> $order_id,
            'user_id' => $user_id
        ])->get();
        // dd($orderItems);
        $orders = DB::table('orders')->where([
            'order_id'=> $order_id,
            'user_id' => $user_id
        ])->first();

        $data = [
            "user_id" =>$user_id,
            "title" => "Order Details",
            // "date" => date('m/d/Y'),
            "orders" => $orders,
            "orderItems" => $orderItems,
            "order_id" => $order_id
            // "price" => $price,
            // "items_cost" => $items_cost,
            // "total_amount_in_naira" => $total_amount_in_naira
        ];

        $pdf = Pdf::loadView('pdfs.order_details2', $data);

        // $pdf = placeOrderPost($request);

        // $pdf = placeOrderPost()->pdf;
        // return redirect('/order-details');
        return $pdf->download('order_invoice.pdf');
    }

    public function createOrderPost(Request $request, $id){
        $user = Auth::user();
        $username = Auth::user()->name;
        $id = Auth::id();
        // $value = $request->input('quantity');
        
        // if 
        $validated = $request->validate([

            // 'quantity' => 'required',
            // 'qty' => 'required',
            'options' => 'required|array|min:1',// 'options' should be an array and contain at least 1 item
            'options.*' => 'required|numeric', // each item in 'options' should be a number
        ]);
    
            // 'quantity' => function ($value) {
            //     $value = $request->options['quantity'];
            //     return $value;
            // },

            // 'options.*' => [
            //     'required',
            //     'integer',
            //     'min:1',
            //     function ($attribute, $value, $fail) use ($request) {
            //         if ($request->input('quantity') && $value <= 0) {
            //             $fail('The quantity must be greater than zero');
            //         }
            //     },
            // ],
            // 'options.*' => 'required|numeric|between:1,10000',
            // 'options.*' => 'required|numeric', new CustomValidationRule($request->input('quantity'))
            // 'quantity' => 'required|numeric|between:1,2000',
        // ]);
        // if ($validated->fails()) {
        //     return redirect('/create-order')
        //                 ->withErrors($validated)
        //                 ->withInput();
        // }

        //no of items ordered

        // $options = array($validated['options']);// this will create a multidim array cos options is already an array
        // dd($options);
        $options = $validated['options'];
        $no_of_items_ordered = count($options);
        // dd($no_of_items_ordered);

        // for ($i=0; $i< $no_of_items_ordered; $i++){
        //     $options[$i] = $request->quantity;
        // }
        // $validated['quantity'] = 
        //total quantity of items

        $total_quantity_of_items = 0;
        for ($i=0; $i < $no_of_items_ordered; $i++) { 
            $total_quantity_of_items += $options[$i];
        }
        // dd($total_quantity_of_items);
        // dd($options);

        // $total_quantity = 0;
        // $item = DB::table('items')->get('id');
        // foreach($options as $x){
        //     foreach($item as $it_id){
        //         // if(Str::contains($request->name('options[]'), $it_id) ){
        //             if ($request->has(['name', 'options[]'])){
        //             // if(Str::contains($request->get($x->options[]), $it_id) ){
        //             $qty = $request->get($x->quantity);
        //             $total_quantity += $qty;
        //         }
        //     }
        // }
        // dd($total_quantity);

        // $total_quantity = 0;
        // $item = DB::table('items')->get('id');
        // foreach($options as $x){
        //     if ($request->has(['name', 'options[]'])){
        //         $qty = $request->input('options[]');
        //         $total_quantity += $qty;
        //     }
        // }
        // dd($total_quantity);
        

        //total amount in naira
        $total_amount_in_naira = $total_quantity_of_items * $request->price;

        //check wallet balance
        $wallet_balance = $user->wallet_balance;
        if($wallet_balance < $total_amount_in_naira){
            return redirect('/create_order')->with('error', 'Insufficient funds available in wallet balance');
        }
        //order details

        $order = new Order;
        $order->user_id = $id;
        $order->order_owner = $username;
        $order->price = $request->input('price');
        $order->no_of_items_in_stock = $request->input('no_of_items_in_stock');
        $order->created_by = $request->input('created_by');
        $order->updated_by = $request->input('updated_by');
        $order->save();
    }

    // public function trackOrder(){
    //     return
    // }
}