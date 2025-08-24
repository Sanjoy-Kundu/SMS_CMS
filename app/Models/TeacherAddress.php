<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAddress extends Model
{
       use HasFactory;
     protected $table = 'teacher_addresses'; 

    // Fillable fields for mass assignment
    protected $fillable = [
        'teacher_id',
        'type',
        'village',
        'district',
        'upazila',
        'post_office',
        'postal_code'
    ];

    /**
     * Relationship with Teacher
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}
