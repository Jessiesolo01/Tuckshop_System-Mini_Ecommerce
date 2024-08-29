<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Rules\CustomValidationRule;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
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
        $request->session()->all();
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

        $quantity_added = $validated['quantity'];
        $deduct_from_stock = $item->no_of_items_in_stock - $quantity_added;

        DB::table('items')->where('id', $request->input('item_id'))
            ->update([
                'no_of_items_in_stock' => $deduct_from_stock,
                'updated_at' => now()
            ]);

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

    public function updateCart(Request $request, $item){
        $request->session()->all();
        $user = Auth::user();
        $id = Auth::id();
        $user_id = Auth::id();
        $username = $user->name;
        
        $cartItem = DB::table('cart')->where('user_id', $user_id)->get();
        //update cart item quantity
        // dd($cartItem);
        for ($i=0; $i < count($cartItem); $i++) { 
            $item_id = $request->input('item_id');
            $item = DB::table('items')
                ->where('id', $item_id)
                ->get();
                // dd($item);
            $cart_id = $request->input('cart_id');
            $input_quantity = (int)$request->input('new_quantity');
            // if($input_quantity == 0){
            //     return redirect('/cart/'.$id)->with('error', "You have to choose a quantity to add to cart");
            // }
            if(($input_quantity != 0) && ($input_quantity != $cartItem[$i]->quantity) && ($input_quantity <= $item[$i]->no_of_items_in_stock)){
                if ($input_quantity > $cartItem[$i]->quantity) {
                    $new_quantity_difference = $input_quantity - $cartItem[$i]->quantity;
                    DB::table('items')->where('id', $item_id)
                        ->update([
                            'no_of_items_in_stock' => $item[$i]->no_of_items_in_stock - $new_quantity_difference,
                            'updated_at' => now()
                        ]);
                }else{
                    $new_quantity_difference = $cartItem[$i]->quantity - $input_quantity;
                    DB::table('items')->where('id', $item_id)
                        ->update([
                            'no_of_items_in_stock' => $item[$i]->no_of_items_in_stock + $new_quantity_difference,
                            'updated_at' => now()
                        ]);
                }
                DB::table('cart')->where('id', $cart_id)
                    ->update([
                        'quantity' => $input_quantity,
                        'updated_at' => now()
                ]);
                
                return redirect('/cart/'.$id)->with('success', "Cart details saved successfully");
            }else{
                return redirect('/cart/'.$id)->with('error', "Item quantity already selected or quantity selected is out of stock");

            }
        }
        
        return redirect('/cart/'.$id)->with(['item' => $item]);
    }

    public function deleteFromCart(Request $request){
        $request->session()->all();
        $user = Auth::user();
        $id = Auth::id();
        $user_id = Auth::id();

        $username = $user->name;
        $cart_id = $request->input('cart_id');
        $cartItem = DB::table('cart')->where('user_id', $user_id)->get();
        $item_id = $request->input('item_id');

        $item = DB::table('items')
            ->where('id', $item_id)
            ->get();
        // dd($item);
        // dd($request->input('quantity'));
        // dd($item->no_of_items_in_stock);

        $input_quantity = $cartItem[0]->quantity;//using this instead of $request->input('quantity) since the input field is disabled
        // dd($input_quantity);
        $add_to_quantity_in_stock = $input_quantity + $item[0]->no_of_items_in_stock;
        // dd($add_to_quantity_in_stock);

        $delete_from_cart = DB::table('cart')
            ->where(['id' => $cart_id])
            ->delete();
        //update quantity in stock after deleting from cart
        
        if($delete_from_cart == true){
            DB::table('items')->where('id', $item_id)
                ->update([
                    'no_of_items_in_stock' => $add_to_quantity_in_stock,
                    'updated_at' => now()
                ]);
        }
        

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
        $item_id = $request->input('item_id');
        $item = DB::table('items')
            ->where('id', $item_id)
            ->get();
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
        return view('users.cart', compact('cartItem', 'user_id', 'id', 'items', 'item'));
        // return view('users.cart', compact('cartItems'));
    }
}
