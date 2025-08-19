<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditorAddress extends Model
{
    use HasFactory;
     protected $table = 'editor_addresses'; // explicit table name

    // Fillable fields for mass assignment
    protected $fillable = [
        'editor_id',
        'type',
        'village',
        'district',
        'upazila',
        'post_office',
        'postal_code'
    ];

    /**
     * Relationship with Editor
     */
    public function editor()
    {
        return $this->belongsTo(Editor::class, 'editor_id');
    }
}
