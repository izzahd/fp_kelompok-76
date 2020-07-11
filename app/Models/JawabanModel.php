<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class JawabanModel {

    public static function get_all($id){
        $jawaban = DB::table('jawaban')->where('pertanyaan_id', $id)->get();
        return $jawaban;
    }

    public static function find_by_id($id){
        $jawaban = DB::table('jawaban')->join('users', 'jawaban.penjawab_id', '=', 'users.id')->select('jawaban.*','users.name')->where('jawaban.pertanyaan_id', $id)->get();
        return $jawaban;
    }

    public static function save($data, $pertanyaan_id){
        $id_user = Auth::id();
        $data += [  "pertanyaan_id" => $pertanyaan_id,
                    "penjawab_id" => $id_user];
        $jawaban_baru = DB::table('jawaban')->insert($data);
        return $jawaban_baru;
    }

    public static function get_by_id($id){
        $jawaban = DB::table('jawaban')->where('id', $id)->first();
        return $jawaban;
    }

    public static function jawaban_solver($idjawaban){
        $jawaban = DB::table('jawaban')->where('id', $idjawaban)->update(['solver' => 1]);
        $dataset=DB::table('jawaban')->where('id', $idjawaban)->first();
        $item2= DB::statement("Update users set poin=poin+15 where id=".$dataset->penjawab_id.";");
        return $jawaban;
    }
}

?>