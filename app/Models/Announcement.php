<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'user_id', 'class_id', 'title', 'description',
        'priority', 'attachment', 'link', 'audience',
        'category', 'recurring', 'read_count', 'is_active', 'valid_until'
    ];
}
