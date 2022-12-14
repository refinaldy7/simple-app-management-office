<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratPertukaranHKSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_pertukaran_h_k_s', function (Blueprint $table) {
            $table->id();
            $table->string('section');
            $table->date('tanggal_kerja_start_date');
            $table->date('tanggal_kerja_end_date');
            $table->time('jam_kerja_start_time');
            $table->time('jam_kerja_end_time');
            $table->unsignedSmallInteger('jumlah_kerja');
            $table->enum('kondisi_kerja', ['Masuk', 'Libur']);
            $table->date('tanggal_pertukaran_start_date');
            $table->date('tanggal_pertukaran_end_date');
            $table->time('jam_pertukaran_start_time');
            $table->time('jam_pertukaran_end_time');
            $table->unsignedSmallInteger('jumlah_pertukaran');
            $table->enum('kondisi_pertukaran', ['Masuk', 'Libur']);
            $table->text('alasan');
            $table->string('evidence')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('letter_type_id')->constrained('letter_types')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surat_pertukaran_h_k_s');
    }
}
