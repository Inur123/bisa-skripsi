<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'operator', 'mahasiswa'])->default('mahasiswa'); // Role column
            $table->string('nim')->unique(); // Unique NIM
            $table->string('fakultas');
            $table->string('prodi');
            $table->string('file'); // File path column
            $table->string('kelompok')->nullable(); // Nullable Kelompok
            $table->string('nohp')->nullable(); // Nomor HP (opsional) dengan panjang maksimum 15 karakter
    $table->text('alamat')->nullable(); // Alamat (opsional), gunakan tipe `text` untuk data lebih panjang
    $table->enum('jeniskelamin', ['Laki-Laki', 'Perempuan'])->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
