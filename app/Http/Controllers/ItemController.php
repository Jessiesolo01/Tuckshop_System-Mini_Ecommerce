<?php

namespace App\Http\Controllers;

use Auth;
use Error;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function addItem(){
        if (Auth::guard('admin')->check()){
            return view('admins.add-item');
        }
        else{
            return redirect('/')->with('error', 'Unauthorized access');
        }
    }
    public function addItemPost(Request $request){
        // auth()->guard('admin')->user();
        $username = Auth::guard('admin')->user()->username;
        $validated = $request->validate([
            'item_name'=> 'required|string',
            'image' => 'required|image|mimes:png,jpg,jpeg,svg,webp',
            'price' => 'required|numeric|between:0.00,9999999.99',
            'no_of_items_in_stock' => 'required|digits_between:0,9',
            'created_by' => 'required',
            'updated_by' => 'required'
        ]);
        $validated['image'] = $request->file('image')->store('uploads', 'public');
        $validated['created_by'] = $username;
        $validated['updated_by'] = $username;
        dd($request->all());

        $item = Item::create($validated);
        return redirect()->to(route('admin.dashboard'));
        // return redirect('/dashboard')->with('status', 'Item created successfully');
    }
    public function showItem(Request $request){
        return view('admins.show-items', [
            'items' => DB::table('items')->paginate(15)
        ]);
    }
  

}
