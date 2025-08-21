<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Admin;
use App\Models\Editor;
use App\Models\Teacher;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    function admin(){
        return $this->hasOne(Admin::class,'user_id', 'id');
    }
        /**
     * Relation: User has one or many Editors
     */
    public function editors()
    {
        return $this->hasMany(Editor::class, 'user_id', 'id');
    }

    /***
     * Relation: User has one or one Editors
     */
        public function editor()
    {
        return $this->hasOne(Editor::class, 'user_id', 'id');
    }


        // Teachers added by this user (1:N)
    public function addedTeachers()
    {
        return $this->hasMany(Teacher::class, 'added_by', 'id');
    }
}
