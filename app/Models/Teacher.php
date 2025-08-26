<?php

namespace App\Models;

use App\Models\User;
use App\Models\ClassModel;
use App\Models\Institution;
use App\Models\TeacherAddress;
use App\Models\TeacherEducation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
   use HasFactory, SoftDeletes;

    protected $table = 'teachers';

    // mass assignable fields
    protected $fillable = [
        'user_id',
        'added_by',
        'institution_id',
        'designation_id',
        'joined_at',
        'is_active',
        'father_name',
        'mother_name',
        'phone',
        'address',
        'about_me',
        'image',
        'nationality',
        'birth_date',
        'nid',
        'gender',
        'religion',
        'marital_status',
    ];

    // date fields
    protected $dates = ['joined_at', 'birth_date', 'deleted_at'];

    // Relationships

    // User relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Institution relation
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    // User who added the teacher
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }



        public function educations()
    {
        return $this->hasMany(TeacherEducation::class);
    }

    public function addresses()
    {
        return $this->hasMany(TeacherAddress::class);
    }

    
}
