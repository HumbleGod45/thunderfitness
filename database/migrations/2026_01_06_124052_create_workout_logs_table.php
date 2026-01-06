<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workout_logs', function (Blueprint $table) {
            $table->id('id_workout_log');

            $table->unsignedBigInteger('id_member');
            $table->unsignedBigInteger('id_trainer')->nullable();
            $table->unsignedBigInteger('id_workout');

            $table->date('tanggal');
            $table->integer('jumlah_set');
            $table->integer('reps');
            $table->float('beban');

            $table->text('catatan')->nullable();

            // timestamp sesuai phpMyAdmin
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')
                  ->useCurrent()
                  ->useCurrentOnUpdate();

            // foreign key
            $table->foreign('id_member')
                  ->references('id_member')
                  ->on('members')
                  ->onDelete('cascade');

            $table->foreign('id_trainer')
                  ->references('id_trainer')
                  ->on('trainers')
                  ->onDelete('set null');

            $table->foreign('id_workout')
                  ->references('id_workout')
                  ->on('workouts')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_logs');
    }
};
