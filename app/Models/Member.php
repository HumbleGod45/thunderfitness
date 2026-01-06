<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';
    protected $primaryKey = 'id_member';
    public $incrementing = true;

    protected $fillable = [
        'Users_id_user',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'tanggal_daftar',
        'aktif_hingga',
        'trainer_id',
        'alamat',
        'tinggi_badan',
        'berat_badan',
        'telp',
        'foto',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
        'aktif_hingga'   => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'Users_id_user', 'id_user');
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id', 'id_trainer');
    }

    public function workoutLogs()
    {
        return $this->hasMany(WorkoutLog::class, 'id_member', 'id_member');
    }
}
