<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VotePertanyaanModel 
{
    public static function get_all(){
    	$items=DB::table('vote_pertanyaan')->get();
    	return $items;
    }

    public static function save($jawaban_id){
        $id_user = Auth::id();
    	$data=["pertanyaan_id" => $jawaban_id];
        $data += ["user_id" => $id_user];
        $new_item= DB::table('vote_pertanyaan')->insert($data);
        return $new_item;
    }

    public static function find_by_id($id_pertanyaan){
        $id_user = Auth::id();
    	$items= DB::table('vote_pertanyaan')->where('pertanyaan_id',$id_pertanyaan)
        ->where('user_id',$id_user)->first();
    	return $items;
    }

    public static function destroy($id_pertanyaan){
        $id_user = Auth::id();
    	$items= DB::table('vote_pertanyaan')->where('pertanyaan_id',$id_pertanyaan)
        ->where('user_id',$id_user)->delete();

        $item2= DB::statement("Update users set poin=poin-1 where id=".$id_user.";");
        return $items;
    }

    public static function get_user_reputation(){
        $id_user = Auth::id();
        $items= DB::table('users')->where('id',$id_user)->first();
        return $items;
    }

}