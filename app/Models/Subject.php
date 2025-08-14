<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Division;
use App\Models\ClassModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'division_id',
        'admin_id',
        'name',
        'code',
        'type',
        'is_active',
    ];
        
    public function classModel(){
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function division(){
        return $this->belongsTo(Division::class, 'division_id');
    }


    public function admin(){
        return $this->belongsTo(Admin::class);
    }

    public function scopeActive($query){
         return $query->where('is_active', true);
    }

}
