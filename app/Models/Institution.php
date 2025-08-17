<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Editor;
use App\Models\AcademicSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Institution extends Model
{
    use HasFactory, SoftDeletes;
      protected $fillable = [
        'admin_id',
        'name',
        'type',
        'eiin',
        'address',
        'parent_id',
    ];
    public const TYPES = ['school', 'college', 'combined']; 

    // Relation: Institution Admin (nullable)
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    // Relation: Institution parent institution (nullable)
    public function parent()
    {
        return $this->belongsTo(Institution::class, 'parent_id');
    }
    // Relation: Institution এর child institutions (multiple)
    public function children()
    {
        return $this->hasMany(Institution::class, 'parent_id');
    }

     public function academicSections()
    {
        return $this->hasMany(AcademicSection::class, 'institution_id');
    }
    /**
     * Relation: Institution has many Editors
     */
    public function editors()
    {
        return $this->hasMany(Editor::class);
    }
}
