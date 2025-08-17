<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Editor extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'user_id',
        'institution_id',
        'designation',
        'joined_at',
        'is_active',
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
        return $this->belongsTo(User::class);
    }

    /**
     * Relation: Editor belongs to an Institution
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
