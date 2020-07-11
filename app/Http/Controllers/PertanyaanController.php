<?php

namespace App\Http\Controllers;
use App\Models\KomentarModel;
use Illuminate\Http\Request;
use App\Models\PertanyaanModel;
use App\Models\JawabanModel;
use App\Models\VotePertanyaanModel;
use App\Models\VoteJawabanModel;
use Illuminate\Support\Facades\Auth;

class PertanyaanController extends Controller
{
    public function index(){
        $pertanyaan = PertanyaanModel::get_all();
        return view('pertanyaan.index', compact('pertanyaan'));
    }

    public function indexsaya(){
        $pertanyaan = PertanyaanModel::get_all_me();
        $saya=1;
        return view('pertanyaan.index', compact('pertanyaan','saya'));
    }

    public function create(){
        $pertanyaan=null;
        return view('pertanyaan.form',compact('pertanyaan'));
    }

    public function store(Request $request){

        $data = $request->all();
        unset($data["_token"]);
        $pertanyaan = PertanyaanModel::save($data);
        if($pertanyaan){
            return redirect('/pertanyaan');
        }
    }

    public function show($id){
        $id_user = Auth::id();
        $pertanyaan = PertanyaanModel::find_by_id($id);
        $jawaban = JawabanModel::find_by_id($id);
        $tags = explode(', ' , $pertanyaan->tag);
        $komentar_p = KomentarModel::find_by_id_p($id);
        $komentar_j = KomentarModel::find_by_id_j($id);
        $vote_tanya = VotePertanyaanModel::find_by_id($id);
        $ureputate = VotePertanyaanModel::get_user_reputation();
        $vote_jawab=array();
        foreach($jawaban as $jawab){
            $vote_jawab[$jawab->id]=VoteJawabanModel::find_by_id($jawab->id);
        }
        $ispenanya=null;
        if($pertanyaan->penanya_id==$id_user){
            $ispenanya=1;
        }
        //dd($id_user);
        return view('pertanyaan.show', compact('pertanyaan', 'jawaban', 'tags', 'komentar_p', 'komentar_j','vote_tanya','ureputate','vote_jawab','ispenanya'));
    }

    public function edit($id){
        $pertanyaan = PertanyaanModel::find_by_id($id);
        return view('pertanyaan.form', compact('pertanyaan'));
    }

    public function update(Request $request, $id){

        $data = $request->all();
        unset($data["_token"]);
        unset($data["_method"]);
        $pertanyaan = PertanyaanModel::update($data, $id);
        if($pertanyaan){
            return redirect('/pertanyaan');
        }
    }

    public function destroy($id){
        $pertanyaan = PertanyaanModel::destroy($id);
        return redirect('/pertanyaan');
    }

    public function vote($id){
        $pertanyaan = VotePertanyaanModel::save($id);
        return redirect('/pertanyaan/'.$id);
    }

    public function downvote($id){
        $pertanyaan = VotePertanyaanModel::destroy($id);
        return redirect('/pertanyaan/'.$id);
    }
}
