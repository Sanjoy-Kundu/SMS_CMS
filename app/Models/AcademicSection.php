<?php

namespace App\Models;

use App\Models\Institution;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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


    public function institution(){
        return $this->belongsTo(Institution::class, 'institution_id');
    }

}
