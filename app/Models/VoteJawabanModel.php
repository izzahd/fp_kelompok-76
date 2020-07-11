<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VoteJawabanModel 
{
    public static function get_all(){
    	$items=DB::table('vote_jawaban')->get();
    	return $items;
    }

    public static function save($jawaban_id){
        $data=["jawaban_id" => $jawaban_id];
        $id_user = Auth::id();
        $data += ["user_id" => $id_user];
    	$new_item= DB::table('vote_jawaban')->insert($data);
    	return $new_item;
    }

    public static function find_by_id($idjawaban){
        $id_user = Auth::id();
    	$items= DB::table('vote_jawaban')->where('jawaban_id',$idjawaban)
        ->where('user_id',$id_user)->first();
    	return $items;
    }

    public static function destroy($idjawaban){
        $id_user = Auth::id();
    	$items= DB::table('vote_jawaban')->where('jawaban_id',$idjawaban)
        ->where('user_id',$id_user)->delete();

        $item2= DB::statement("Update users set poin=poin-1 where id=".$id_user.";");
    	return $items;
    }


}