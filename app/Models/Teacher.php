<?php

namespace App\Models;

use App\Models\User;
use App\Models\ClassModel;
use App\Models\Institution;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
   use HasFactory, SoftDeletes;

    protected $table = 'teachers';

    // mass assignable fields
    protected $fillable = [
        'user_id',
        'added_by',
        'institution_id',
        'joined_at',
        'is_active',
        'father_name',
        'mother_name',
        'phone',
        'address',
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

    // // Classes relation (Many-to-Many) with pivot table for designation
    // public function classes()
    // {
    //     return $this->belongsToMany(ClassModel::class, 'class_teacher')
    //                 ->withPivot('designation')
    //                 ->withTimestamps();
    // }

    // // Teacher's addresses
    // public function addresses()
    // {
    //     return $this->hasMany(TeacherAddress::class);
    // }

    // // Teacher's educations
    // public function educations()
    // {
    //     return $this->hasMany(TeacherEducation::class);
    // }
}
