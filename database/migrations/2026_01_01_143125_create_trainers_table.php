<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trainers', function (Blueprint $table) {
            $table->id('id_trainer');

            $table->unsignedBigInteger('Users_id_user');

            $table->string('nama', 255)->nullable();
            $table->string('spesialis', 255)->nullable();
            $table->integer('pengalaman_tahun')->nullable();
            $table->string('telp', 20)->nullable();

            $table->string('foto', 255); // NOT NULL

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            // Foreign key ke users
            $table->foreign('Users_id_user')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainers');
    }
};
