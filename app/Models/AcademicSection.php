<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AcademicSection extends Model
{
    use HasFactory,SoftDeletes;
     protected $fillable = [
        'institution_id',
        'admin_id',
        'section_type',
        'approval_letter_no',
        'approval_date',
        'approval_stage',
        'level',
    ];

}
