<?php

namespace App\Http\Controllers;
use App\Models\JawabanModel;
use App\Models\PertanyaanModel;
use App\Models\KomentarModel;
use Illuminate\Http\Request;
use App\Models\VoteJawabanModel;
use App\Models\VotePertanyaanModel;

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

    public function vote($tanyaid,$id){
        $pertanyaan = VoteJawabanModel::save($id);
        return redirect('/pertanyaan/'.$tanyaid);
    }

    public function downvote($tanyaid,$id){
        $pertanyaan = VoteJawabanModel::destroy($id);
        return redirect('/pertanyaan/'.$tanyaid);
    }

    public function solver($tanyaid,$id){
        $pertanyaan = JawabanModel::jawaban_solver($id);
        return redirect('/pertanyaan/'.$tanyaid);
    }
}
