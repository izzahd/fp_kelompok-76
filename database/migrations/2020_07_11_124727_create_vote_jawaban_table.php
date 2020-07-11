<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoteJawabanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vote_jawaban', function (Blueprint $table) {
            $table->unsignedBigInteger('jawaban_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->primary(['jawaban_id','user_id']);
            $table->foreign('jawaban_id')->references('id')->on('jawaban');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        DB::unprepared('
        CREATE TRIGGER vote_jawaban_added AFTER INSERT ON `vote_jawaban` FOR EACH ROW
            BEGIN
                DECLARE jaw_user_id BIGINT;
                SELECT penjawab_id
                INTO @jaw_user_id
                FROM jawaban
                WHERE jawaban.id= NEW.jawaban_id;

                update users set poin=poin+10 where id=@jaw_user_id;
            END ;
        ');

        DB::unprepared('
        CREATE TRIGGER vote_jawaban_deleted AFTER DELETE ON `vote_jawaban` FOR EACH ROW
            BEGIN
                DECLARE jaw_user_id BIGINT;
                SELECT penjawab_id
                INTO @jaw_user_id
                FROM jawaban
                WHERE jawaban.id= OLD.jawaban_id;

                update users set poin=poin-10 where id=@jaw_user_id;
            END ;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vote_jawaban');
        DB::unprepared('DROP TRIGGER `vote_jawaban_added`');
        DB::unprepared('DROP TRIGGER `vote_jawaban_deleted`');

    }
}
