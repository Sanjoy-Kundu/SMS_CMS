<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Subject;
use App\Models\ClassModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['class_id', 'admin_id', 'name'];

    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
      
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
