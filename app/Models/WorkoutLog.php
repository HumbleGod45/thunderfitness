<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutLog extends Model
{
    use HasFactory;

    protected $table = 'workout_logs';
    protected $primaryKey = 'id_workout_log';

    protected $fillable = [
        'id_member',
        'id_trainer',
        'id_workout',
        'tanggal',
        'jumlah_set',
        'reps',
        'beban',
        'catatan',
    ];

    /**
     * Relasi ke Member
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member', 'id_member');
    }

    /**
     * Relasi ke Trainer (nullable)
     */
    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'id_trainer', 'id_trainer');
    }

    /**
     * Relasi ke Workout (master latihan)
     */
    public function workout()
    {
        return $this->belongsTo(Workout::class, 'id_workout', 'id_workout');
    }
}
