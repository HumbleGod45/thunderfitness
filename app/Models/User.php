<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// import model relasi
use App\Models\Member;
use App\Models\Trainer;
use App\Models\Admin;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function getAuthIdentifierName()
    {
        return 'id_user';
    }

    public function member()
    {
        return $this->hasOne(Member::class, 'Users_id_user', 'id_user');
    }

    public function trainer()
    {
        return $this->hasOne(Trainer::class, 'Users_id_user', 'id_user');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'Users_id_user', 'id_user');
    }
}
