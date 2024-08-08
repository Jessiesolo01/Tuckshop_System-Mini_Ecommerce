<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Rules\CustomValidationRule;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // public function createOrder(Request $request){
    //     $username = Auth::user()->name;
    //     $id = Auth::id();
    //     $items = DB::table('items')->get();
    //     // $value = $request->input('quantity');
    //     return view('users.create-order', compact('username', 'items', 'id'));
    // }
    public function createOrder(Request $request){
        $username = Auth::user()->name;
        $id = Auth::id();
        // $items = DB::table('items')->get();
        $items = DB::table('items')->paginate(30);

        // $value = $request->input('quantity');
        return view('users.place-order', compact('username', 'items', 'id'));
    }
    // public function addToCart(Request $request, $id){
    //     $user = Auth::user();
    //     $username = Auth::user()->name;
    //     $id = Auth::id();
    //     $validated = $request->validate([
    //         'options' => 'required|array|min:1',// 'options' should be an array and contain at least 1 item
    //         'options.*' => 'required|numeric', // each item in 'options' should be a number
    //     ]); 
    // }

    public function addToCart(Request $request)
    {   
        $user = Auth::user();
        $username = Auth::user()->name;
        $id = Auth::id();
        $validated = $request->validate([
            'item_id' => 'required|integer|exists:items,id',
            // 'item_name' => 'required|string',
            // 'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1'
        ]);

        // Cart::add($validated['item_id'], $validated['item_name'], $validated['quantity'], $validated['price']);
        $item = Item::find($request->input('item_id'));

        // dd($item);
        $item_exists = DB::table('cart')
                ->where('user_id', $request->input('id'))
                ->where('item_id', $request->input('item_id'))->first();
            // ->where();
        if($item_exists){
            return redirect('/create-order')->with('error', 'Item already exists in cart');
        }


        $cart = new Cart;
        $cart->item_id = $request->input('item_id');
        $cart->user_id = $request->input('id');
        $cart->order_owner = $username;
        $cart->item_name = $item->item_name;
        $cart->image = $item->image;
        $cart->price = $item->price;
        $cart->quantity = $request->input('quantity');
        $cart->created_by = $username;
        $cart->updated_by = $username;
        $cart->save();

        return redirect('/create-order')->with('success', 'Item added to cart successfully!');
    }

    public function deleteFromCart(Request $request){
        $request->session()->all();
        $user = Auth::user();
        $id = Auth::id();
        $username = $user->name;
        $cart_id = $request->input('cart_id');

        DB::table('cart')
            ->where(['id' => $cart_id])
            ->delete();

        return redirect('/cart/'. $id)->with('success', 'Item successfully deleted from cart');
    }
    
    public function cart(Request $request, $cartItem)
    {
        $request->session()->all();
        $user = Auth::user();
        $id = Auth::id();
        $user_id = Auth::id();
        $username = $user->name;

        $item_id = DB::table('cart')->get('item_id');
        // $cart_user_id = DB::table('cart')->get('user_id')->unique();
        $cart_user_id = DB::table('cart')->distinct()->get('user_id');
        // $cart_user_id = DB::table('cart')->get('user_id')->unique();
        // dd($cart_user_id);
        // $item_id = DB::table('items')->get('id');
        // $user_id = DB::table('users')->get('id');
        // dd($item_id);
        // dd($user_id);

        // $item_id = $cart->item_id;
        $cartItem = DB::table('cart')->get();
        $items = DB::table('items')->get('id');
        // for ($i=0; $i < count($items); $i++) { 
        //     # code...
        //     for ($x=0; $x < count($item_id); $x++) { 
        //         if ($item_id[$x] == $items[$i] ) {
        //             DB::table('cart')->get()->where('item_id', $item_id[$x]);
        //         }
        //     }
           
        // }
            // ->where('id', $item_id);
            // $items = DB::table('item')
            //     ->where('id', $item_id)
            //     ->get();

        // dd($items);

        // $cartItems = Cart::with('items')->get();
        // $cartItems = DB::table('cart')->get('user_id');
        // $cartItems = DB::table('cart')->paginate(10);
        // for ($i=0; $i < count($cart_user_id); $i++) { 
        //         # code... 
        //             if ($cart_user_id[$i] === $user_id) {
        //                 $cartItem = DB::table('cart')->where('user_id', $user_id)->first();
                        
        //         }
               
        //     }
            $cartItem = DB::table('cart')->where('user_id', $user_id)->get();

            // dd($cartItem);
        return view('users.cart', compact('cartItem', 'user_id', 'id', 'items'));
        // return view('users.cart', compact('cartItems'));
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
        dd($options);

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