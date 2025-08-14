<?php

namespace App\Models;

use App\Models\Subject;
use App\Models\Division;
use App\Models\AcademicSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassModel extends Model
{
    use HasFactory,SoftDeletes;
     protected $fillable = [
        'academic_section_id',
        'admin_id',
        'name',
    ];

    public function academicSection(){
        return $this->belongsTo(AcademicSection::class, 'academic_section_id');
    }
    public function divisions(){
        return $this->hasMany(Division::class, 'class_id');
    }

    public function subjects(){
        return $this->hasMany(Subject::class, 'class_id');
    }
}
