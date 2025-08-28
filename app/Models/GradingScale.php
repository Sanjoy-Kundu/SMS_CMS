<?php

namespace App\Models;

use App\Models\User;
use App\Models\ClassModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GradingScale extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'class_id',
        'grade',
        'gpa',
        'min_range',
        'max_range',
    ];

    // Relation to Class
    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    // Relation to User (who created this)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
