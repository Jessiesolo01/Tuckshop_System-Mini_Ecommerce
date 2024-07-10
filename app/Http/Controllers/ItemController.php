<?php

namespace App\Http\Controllers;

use Session;
use Auth;
use Error;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function addItem(){
        if (Auth::guard('admin')->check()){
            // $request->session()->all();
            $username = Auth::guard('admin')->user()->username;
            $id =Auth::guard('admin')->user()->id;
            return view('admins.add-item', compact('username', 'id'));
        }
        else{
            return redirect('/')->with('error', 'Unauthorized access');
        }
    }
    public function addItemPost(Request $request){
        // auth()->guard('admin')->user();
        $request->session()->all();
        $username = Auth::guard('admin')->user()->username;
        $id = Auth::guard('admin')->user()->id;
        $validated = $request->validate([
            'item_name'=> 'required|string',
            'image' => 'required|image|mimes:png,jpg,jpeg,svg,webp',
            'price' => 'required|numeric|between:0.00,9999999.99',
            'no_of_items_in_stock' => 'required|digits_between:0,9',
            'created_by' => 'required',
            'updated_by' => 'required'
        ]);
        $validated['image'] = $request->file('image')->store('uploads', 'public');
        // $validated['created_by'] = $username;
        // $validated['updated_by'] = $username;
        // dd($request->all());

        $item = Item::create($validated);
        $item_id = $item->id;
        return redirect()->to(route('admin.dashboard', [$id]))->with('status', 'Item added successfully');

        // return redirect()->to(route('admin.dashboard', [$id]))->with(compact('id', 'username'));
        // return redirect('/dashboard')->with('status', 'Item created successfully');
    }

    public function editItem(Request $request, $id){//the id here is the param from the url(/edit-item/{id})
        if (Auth::guard('admin')->check()){
            // $request->session()->all();
            $username = Auth::guard('admin')->user()->username;
            $item = Item::find($id);//the id is the one in the function param, this finds an item with this id        
            return view('admins.edit-item', compact('username', 'item'));
        }
        else{
            return redirect('/')->with('error', 'Unauthorized access');
        }
    }
    public function updateItem(Request $request, $id){
        // auth()->guard('admin')->user();
        $request->session()->all();
        $username = Auth::guard('admin')->user()->username;
        // $id =Auth::guard('admin')->user()->id;

        $item = Item::find($id);
        $id = $item->id;
        $validated = $request->validate([
            'item_name'=> 'string',
            'image' => 'image|mimes:png,jpg,jpeg,svg,webp',
            'price' => 'numeric|between:0.00,9999999.99',
            'no_of_items_in_stock' => 'digits_between:0,9',
            'updated_by' => 'required',
            // 'updated_at' => 'required'
        ]);
        $validated['image'] = $request->file('image')->store('uploads', 'public');
        $validated['image'] = $request->file('image')->getClientOriginalName();
        Item::where('id', $item->id)
            ->update([
                'item_name' => $request->item_name,
                'image' => $request->image,
                'price' => $request->price,
                'no_of_items_in_stock' => $request->no_of_items_in_stock,
                'updated_by' => $request->updated_by,
                // "updated_at"=>Carbon::now(),
                // 'updated_at' => $request->updated_at
            ]);
        return redirect()->to(route('admin.dashboard', [$id]))->with('status', 'Item updated successfully');

    }

    public function showItem(Request $request, Item $item){
        return view('admins.show-items', [
            'items' => DB::table('items')->paginate(15)
            // 'item' => $item
            // 'items' => $items
        ]);
    }
  

}
