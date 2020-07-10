@extends('adminlte.master')

@section('content')
    <div class="mx-3 pt-3">
        <h2>Edit Pertanyaan</h2>
        <form action="/pertanyaan/{{$pertanyaan->id}}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
            <label for="judul">Judul :</label>
            <input type="text" class="form-control" id="judul" placeholder="Judul pertanyaan" name="judul" value="{{ $pertanyaan->judul }}">
            </div>
            <div class="form-group">
            <label for="isi">Isi :</label>
            <textarea class="form-control" id="isi" placeholder="Isi pertanyaan" name="isi" rows="3">{{ $pertanyaan->isi }}</textarea>
            </div>
            <div class="form-group">
            <label for="tag">Tag :</label>
            <input type="text" class="form-control" id="tag" placeholder="Tag pertanyaan" name="tag" value="{{ $pertanyaan->tag }}">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    
@endsection