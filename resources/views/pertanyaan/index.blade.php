@extends('adminlte.master')

@section('content')
    <div class="mx-3 py-3">
        <h3>Pertanyaan</h3>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Isi</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody class="table-light">
                @foreach ($pertanyaan as $key => $item)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$item->judul}}</td>
                    <td>{!! $item->isi !!}</td>
                    <td>
                        <a href="/pertanyaan/{{ $item->id }}" class="btn btn-sm btn-primary mr-2" role="button">Lihat</a>
                        @isset($saya)
                        <a href="/pertanyaan/{{ $item->id }}/edit" class="btn btn-sm btn-light mr-2" role="button">Ubah</a>
                        <form action="/pertanyaan/{{ $item->id }}" method="post" style="display: inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger mr-2">Hapus</button>
                        </form>
                        @endisset
                    </td>
                </tr>              
                @endforeach
            </tbody>
        </table>
    </div>
    
@endsection