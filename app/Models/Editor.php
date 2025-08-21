<?php

namespace App\Models;

use App\Models\User;
use App\Models\Institution;
use App\Models\EditorAddress;
use App\Models\EditorEducation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Editor extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'user_id',
        'institution_id',
        'designation',
        'joined_at',
        'is_active',
        'father_name',
        'mother_name',
        'nationality',
        'religion',
        'marital_status',
        'phone',
        'address',
        'image',
        'birth_date',
        'nid',
        'gender',
    ];
    protected $dates = [
        'joined_at',
        'deleted_at',
    ];
    /**
     * Relation: Editor belongs to a User
     */
    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'email');
    }

    /**
     * Relation: Editor belongs to an Institution
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    // app/Models/Editor.php
    public function educations()
    {
        return $this->hasMany(EditorEducation::class);
    }

    public function addresses()
    {
        return $this->hasMany(EditorAddress::class);
    }
}
