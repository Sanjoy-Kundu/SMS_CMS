<?php

namespace App\Models;

use App\Models\Teacher;
use App\Models\Institution;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Designation extends Model
{
     use HasFactory, SoftDeletes;

    protected $fillable = [
        'institution_id',
        'title',
    ];

    /**
     * A designation belongs to an institution
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    /**
     * A designation can have many teachers
     */
    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }
}
