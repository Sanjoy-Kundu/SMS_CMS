<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "phone",
        "address",
        "image",
        "birth_date",
        "nid",
        "gender",
        "is_active"
    ];

    protected $casts = [
    'birth_date' => 'date',
    'is_active' => 'boolean'
   ];

   function user(){
    return $this->belongsTo(User::class, 'user_id','id');
   }
}
