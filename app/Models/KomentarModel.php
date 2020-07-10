<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KomentarModel {

    public static function get_all_p($id){
        $komentar = DB::table('komentar')->where('pertanyaan_id', $id)->get();
        return $komentar;
    }

    public static function find_by_id_p($id){
        $komentar = DB::table('komentar')->join('users', 'komentar.komentator_id', '=', 'users.id')->select('komentar.*','users.name')->where('komentar.pertanyaan_id', $id)->get();
        return $komentar;
    }

    public static function save_p($data, $pertanyaan_id){
        $id_user = Auth::id();
        $data += [  "pertanyaan_id" => $pertanyaan_id,
                    "komentator_id" => $id_user];
        $komentar_baru = DB::table('komentar')->insert($data);
        return $komentar_baru;
    }

    public static function get_all_j($id){
        $komentar = DB::table('komentar')->where('jawaban_id', $id)->get();
        return $komentar;
    }

    public static function find_by_id_j($id){
        $jawaban = DB::table('jawaban')
                   ->select('id')
                   ->where('pertanyaan_id', $id);

        $komentar1 = DB::table('komentar')
                ->joinSub($jawaban, 'jawaban_tanya', function ($join) {
                    $join->on('komentar.jawaban_id', '=', 'jawaban_tanya.id');
                })
                ->join('users', 'komentar.komentator_id', '=', 'users.id')->get();

        //$komentar = DB::table('komentar')->join('users', 'komentar.komentator_id', '=', 'users.id')->select('komentar.*','users.name')->where('komentar.jawaban_id', $id)->get();
        return $komentar1;
    }

    public static function save_j($data, $jawaban_id){
        $id_user = Auth::id();
        $data += [  "jawaban_id" => $jawaban_id,
                    "komentator_id" => $id_user];
        $komentar_baru = DB::table('komentar')->insert($data);
        return $komentar_baru;
    }
}