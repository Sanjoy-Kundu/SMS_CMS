<?php

namespace App\Models;

use App\Models\Editor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EditorEducation extends Model
{
    use HasFactory,SoftDeletes;
     protected $table = 'editor_educations';
        protected $fillable = [
        'editor_id',
        'level',
        'roll_number',
        'board_university',
        'result',
        'passing_year',
        'course_duration',
    ];

        public function editor()
    {
        return $this->belongsTo(Editor::class);
    }
}
