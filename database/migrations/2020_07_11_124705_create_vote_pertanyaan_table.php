<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotePertanyaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vote_pertanyaan', function (Blueprint $table) {
            $table->unsignedBigInteger('pertanyaan_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->primary(['pertanyaan_id','user_id']);
            $table->foreign('pertanyaan_id')->references('id')->on('pertanyaan');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        DB::unprepared('
        CREATE TRIGGER vote_pertanyaan_added AFTER INSERT ON `vote_pertanyaan` FOR EACH ROW
            BEGIN
                DECLARE jaw_user_id BIGINT;
                SELECT penanya_id
                INTO @jaw_user_id
                FROM pertanyaan
                WHERE pertanyaan.id= NEW.pertanyaan_id;

                update users set poin=poin+10 where id=@jaw_user_id;
            END ;
        ');

        DB::unprepared('
        CREATE TRIGGER vote_pertanyaan_deleted AFTER DELETE ON `vote_pertanyaan` FOR EACH ROW
            BEGIN
                DECLARE jaw_user_id BIGINT;
                SELECT penanya_id
                INTO @jaw_user_id
                FROM pertanyaan
                WHERE pertanyaan.id= OLD.pertanyaan_id;

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
        Schema::dropIfExists('vote_pertanyaan');
        DB::unprepared('DROP TRIGGER `vote_pertanyaan_added`');
        DB::unprepared('DROP TRIGGER `vote_pertanyaan_deleted`');
    }
}
