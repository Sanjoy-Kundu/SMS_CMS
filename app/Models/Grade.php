<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $fillable = [
        'institution_id',
        'class_id',
        'grade',
        'gpa',
        'min_mark',
        'max_mark',
        'is_active',
    ];

    // Relationships

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
