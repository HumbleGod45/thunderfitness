<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id('id_member');

            $table->unsignedBigInteger('Users_id_user');

            $table->string('nama', 255)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin', 50)->nullable();
            $table->date('tanggal_daftar')->nullable();
            $table->date('aktif_hingga')->nullable();

            $table->unsignedBigInteger('trainer_id')->nullable();

            $table->string('alamat', 255)->nullable();
            $table->integer('tinggi_badan');
            $table->integer('berat_badan');
            $table->string('telp', 20)->nullable();
            $table->string('foto', 255)->nullable();

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
        Schema::dropIfExists('members');
    }
};
