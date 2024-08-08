<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'items';
    protected $fillable = [
        'item_name',
        'image',
        'price',
        'no_of_items_in_stock',
        'created_by',
        'updated_by'
        ];
    public function cart(){
        $this->belongsTo('App\Models\Cart');
    }
}
