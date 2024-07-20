<?php

namespace App\Http\Controllers;

use Auth;
use Error;
use Session;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
    // public function addItemPost(Request $request){
    //     // auth()->guard('admin')->user();
    //     $request->session()->all();
    //     $username = Auth::guard('admin')->user()->username;
    //     $id = Auth::guard('admin')->user()->id;
    //     $validated = $request->validate([
    //         'item_name'=> 'required|string',
    //         'image' => 'required|image|mimes:png,jpg,jpeg,svg,webp',
    //         'price' => 'required|numeric|between:0.00,9999999.99',
    //         'no_of_items_in_stock' => 'required|digits_between:0,9',
    //         'created_by' => 'required',
    //         'updated_by' => 'required'
    //     ]);
    //     $validated['image'] = $request->file('image')->store('uploads', 'public');
    //     // $validated['created_by'] = $username;
    //     // $validated['updated_by'] = $username;
    //     // dd($request->all());

    //     $item = Item::create($validated);
    //     $item_id = $item->id;
    //     return redirect()->to(route('admin.dashboard', [$id]))->with('status', 'Item added successfully');

    //     // return redirect()->to(route('admin.dashboard', [$id]))->with(compact('id', 'username'));
    //     // return redirect('/dashboard')->with('status', 'Item created successfully');
    // }

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
        // $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('uploads', $imageName, 'public');
        }
        $item = new Item();
        $item->item_name = $request->input('item_name');
        $item->image = $imagePath;
        $item->price = $request->input('price');
        $item->no_of_items_in_stock = $request->input('no_of_items_in_stock');
        $item->created_by = $request->input('created_by');
        $item->updated_by = $request->input('updated_by');
        $item->save();

        return redirect()->to(route('admin.dashboard', [$id]))->with('status', 'Item added successfully');
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
    // public function updateItem(Request $request, $id){
    //     // auth()->guard('admin')->user();
    //     $request->session()->all();
    //     $username = Auth::guard('admin')->user()->username;
    //     // $id =Auth::guard('admin')->user()->id;

    //     $item = Item::find($id);
    //     $id = $item->id;
    //     $validated = $request->validate([
    //         'item_name'=> 'string',
    //         'image' => 'image|mimes:png,jpg,jpeg,svg,webp|nullable',
    //         'price' => 'numeric|between:0.00,9999999.99',
    //         'no_of_items_in_stock' => 'digits_between:0,9',
    //         'updated_by' => 'required',
    //         // 'updated_at' => 'required'
    //     ]);
    //     // if($validated['image'] !== null){
    //     //     $validated['image'] = $request->file('image')->store('uploads', 'public');
    //     //     $validated['image'] = $request->file('image')->getClientOriginalName();
    //     // }
    //     $old_image = $request->old_image;
    //     if ($request->hasFile('image')) {
    //         $validated['image'] = $request->file('image')->store('uploads', 'public');

    //         $image = $request->file('image');
    //         // $imageName = $image->getClientOriginalExtension();
    //         // $imageName->save();
    //         // dd($imageName);
    //         $imageName = time() . '_' . $image->getClientOriginalName();
    //         $imagePath = '/uploads/';
    //         $image->move(public_path($imagePath), $imageName);
    //         // unlink('storage/'.$old_image);
    //         // $request->file('image')->storeAs($image,'public');
    //         Storage::disk('public')->put("uploads", $imageName);

    //         // link($imageName,'storage/uploads/');
    //     }
    //     // $image = $request->file('image');
    //     // $name_gen = hexdec(uniqid());
    //     // $img_ext = strtolower($image->getClientOriginalExtension());
    //     // $img_name = $name_gen.'.'.$img_ext;
    //     // $up_location = 'uploads/';
    //     // $up_location = $request->file('image')->store('uploads', 'public');

    //     // $last_img = $up_location.$img_name;
    //     // $image->move($up_location, $img_name);
        
    //     Item::where('id', $item->id)
    //         ->update([
    //             'item_name' => $request->item_name,
    //             'image' => $imagePath.$imageName,
    //             'price' => $request->price,
    //             'no_of_items_in_stock' => $request->no_of_items_in_stock,
    //             'updated_by' => $request->updated_by,
    //             // "updated_at"=>Carbon::now(),
    //             // 'updated_at' => $request->updated_at
    //         ]);
    //     return redirect()->to(route('admin.dashboard', [$id]))->with('status', 'Item updated successfully');

    // }

    public function updateItem(Request $request, $id){
        // auth()->guard('admin')->user();
        $request->session()->all();
        $username = Auth::guard('admin')->user()->username;
        $admin_id =Auth::guard('admin')->user()->id;

        $item = Item::find($id);
        $id = $item->id;
        $validated = $request->validate([
            'item_name'=> 'string',
            'image' => 'image|mimes:png,jpg,jpeg,svg,webp|nullable',
            'price' => 'numeric|between:0.00,9999999.99',
            'no_of_items_in_stock' => 'digits_between:0,9',
            'updated_by' => 'required',
            // 'updated_at' => 'required'
        ]);
        // $imagePath = null;

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($item->image);

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('uploads', $imageName, 'public');
            $item->image = $imagePath;
        }//else{
        //     $imagePath = $request->old_image;
        // }
        // $model = Item::find($id);
        $item->item_name = $request->input('item_name');
        
        $item->price = $request->input('price');
        $item->no_of_items_in_stock = $request->input('no_of_items_in_stock');
        // $item->created_by = $request->input('created_by');
        $item->updated_by = $request->input('updated_by');

        $item->save();
        // if ($request->hasFile('image')) {
        //     // Delete old image if necessary
        //     Storage::disk('public')->delete($item->image);

        //     // Update image path
        //     $item->image = $imagePath;

        // }
        // $item->save();
        return redirect()->to(route('admin.dashboard', [$admin_id]))->with('status', 'Item updated successfully');

    }



    public function showItem(Request $request, Item $item){

        return view('admins.show-items', [
            'items' => DB::table('items')->paginate(30)
            // 'item' => $item
            // 'items' => $items
        ]);
    }
    public function deleteItem(Request $request, $id){
        // auth()->guard('admin')->user();
        $request->session()->all();
        $username = Auth::guard('admin')->user()->username;
        $admin_id =Auth::guard('admin')->user()->id;

        $item = Item::find($id);
        $id = $item->id;
        DB::table('items')
            ->where(['id' => $id])
            ->delete();
        return redirect()->to(route('admin.dashboard', [$admin_id]))->with('status', 'Item deleted successfully');

    }

}
