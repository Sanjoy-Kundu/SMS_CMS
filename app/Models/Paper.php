<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Paper extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'subject_id',
        'name',
        'code',
        'admin_id',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
