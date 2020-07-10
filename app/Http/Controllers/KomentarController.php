<?php

namespace App\Http\Controllers;
use App\Models\KomentarModel;
use App\Models\JawabanModel;
use App\Models\PertanyaanModel;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
    public function create_p(){
        return view('komentar.form');
    }

    public function create_j(){
        return view('komentar.form2');
    }

    public function store_p(Request $request, $id){
        $data = $request->all();
        unset($data["_token"]);
        $komentar = KomentarModel::save_p($data, $id);
        if($komentar){
            return redirect()->route('pertanyaan', ['id' => $id]);
        }
    }

    public function store_j(Request $request, $id, $id2){
        $data = $request->all();
        unset($data["_token"]);
        $komentar = KomentarModel::save_j($data, $id2);
        if($komentar){
            return redirect()->route('pertanyaan', ['id' => $id]);
        }
    }
}
