<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKomentarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komentar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('isi');
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->timestamp('tanggal_diperbaharui')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('pertanyaan_id')->nullable();
            $table->foreign('pertanyaan_id')->references('id')->on('pertanyaan');
            $table->unsignedBigInteger('jawaban_id')->nullable();
            $table->foreign('jawaban_id')->references('id')->on('jawaban');
            $table->unsignedBigInteger('komentator_id');
            $table->foreign('komentator_id')->references('id')->on('users');
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
        Schema::dropIfExists('komentar');
    }
}
