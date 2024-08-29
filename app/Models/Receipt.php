<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    protected $table = 'receipts';
    protected $fillable = [
        'user_id',
        'user_name',
        'file',
        'uploaded_by',
        'updated_by'
        ];

        
    public function user(){
        return $this->belongsTo(User::class);
    }

}
