<?php

namespace App\Http\Controllers;
use App\Models\JawabanModel;
use App\Models\PertanyaanModel;
use App\Models\KomentarModel;
use Illuminate\Http\Request;

class JawabanController extends Controller
{
    public function index($id){
        $jawaban = JawabanModel::get_all($id);
        return view('jawaban.index', compact('jawaban', 'id'));
    }

    public function store(Request $request, $id){
        $data = $request->all();
        unset($data["_token"]);
        $jawaban = JawabanModel::save($data, $id);
        if($jawaban){
            return redirect()->route('pertanyaan', ['id' => $id]);
        }
    }
}
