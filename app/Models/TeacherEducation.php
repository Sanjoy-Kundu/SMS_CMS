<?php

namespace App\Models;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TeacherEducation extends Model
{
  
    use HasFactory,SoftDeletes;
     protected $table = 'teacher_educations';
        protected $fillable = [
        'teacher_id',
        'level',
        'roll_number',
        'board_university',
        'result',
        'passing_year',
        'course_duration',
    ];

        public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
