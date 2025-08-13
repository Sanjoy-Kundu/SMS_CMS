<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory,SoftDeletes;
     protected $fillable = [
        'academic_section_id',
        'admin_id',
        'name',
    ];

    public function academicSection()
    {
        return $this->belongsTo(AcademicSection::class, 'academic_section_id');
    }
}
