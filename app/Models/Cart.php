<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    protected $fillable = [
        'user_id',
        'order_owner',
        'item_id',
        'item_name',
        'image',
        'quantity',
        'price',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
        ];
    // public function item(){
    //     return $this->hasMany('App\Models\Item', 'id', 'item_id');
    // }
    // public function user()
    // {
    //     return $this->belongsTo('App\Models\User', 'id', 'user_id');
    // }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function item(){
        return $this->belongsTo(Item::class);
    }
}
