<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;

    protected $table = 'trainers';
    protected $primaryKey = 'id_trainer';
    public $incrementing = true;

    protected $fillable = [
        'users_id_user',
        'nama',
        'spesialis',
        'pengalaman_tahun',
        'telp',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id_user', 'id_user');
    }

/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Get the members of the trainer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
/*******  077450d0-5c28-486d-b162-b04a3743f5bd  *******/
    public function members()
    {
        return $this->hasMany(Member::class, 'trainer_id', 'id_trainer');
    }

    public function workoutLogs()
    {   
        return $this->hasMany(WorkoutLog::class, 'id_trainer', 'id_trainer');
    }
}
