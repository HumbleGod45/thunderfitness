<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $table = 'workouts';
    protected $primaryKey = 'id_workout';

    protected $fillable = [
        'tanggal',
        'nama_latihan',
        'jumlah_set',
        'reps',
        'beban',
    ];

    /**
     * Relasi ke workout log
     * 1 workout bisa muncul di banyak catatan latihan
     */
    public function workoutLogs()
    {
        return $this->hasMany(WorkoutLog::class, 'id_workout', 'id_workout');
    }
}
