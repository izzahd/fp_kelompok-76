<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PertanyaanModel {
    public static function get_all(){
        $pertanyaan = DB::table('pertanyaan')->get();
        return $pertanyaan;
    }

    public static function save($data){
        $id_user = Auth::id();
        $data += ["penanya_id" => $id_user];
        $pertanyaan_baru = DB::table('pertanyaan')->insert($data);
        return $pertanyaan_baru;
    }

    public static function find_by_id($id){
        $pertanyaan = DB::table('pertanyaan')->join('users', 'pertanyaan.penanya_id', '=', 'users.id')->select('pertanyaan.*','users.name')->where('pertanyaan.id', $id)->first();
        return $pertanyaan;
    }

    public static function update($data, $id){
        $pertanyaan_baru = DB::table('pertanyaan')->where('id', $id)->update($data);
        return $pertanyaan_baru;
    }

    public static function destroy($id){
        $pertanyaan = DB::table('pertanyaan')->where('id', $id)->delete();
        return $pertanyaan;
    }

    public static function find_username($id){
        $user = DB::table('users')->where('id', $id)->first();
        $username = $user->name;
        return $username;
    }
}

?>