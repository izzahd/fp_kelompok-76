@extends('adminlte.master')

@push('script-head')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endpush

@section('content')
    <div class="mx-3 pt-3">
        <h3>{{ $pertanyaan->judul }}</h3>
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <p class="card-text">{!! $pertanyaan->isi !!}</p>
                        @foreach ($tags as $item)
                        <a href="#" class="btn btn-sm btn-primary mr-2" role="button">{{$item}}</a>
                        @endforeach
                        <p class="card-text text-secondary" style="text-align: right"><i>{{$pertanyaan->name}} | Tanggal dibuat : {{ $pertanyaan->tanggal_dibuat }} | Tanggal diperbaharui : {{ $pertanyaan->tanggal_diperbaharui }}</i> </p>
                        <div class="media mx-5">
                            <div class="media-body">
                                @foreach ($komentar_p as $komen)
                                <hr>
                                <p>{{$komen->isi}} <i class="text-secondary">- oleh {{$komen->name}} pada {{$komen->tanggal_dibuat}}</i></p>
                                @endforeach
                                <hr>
                            </div>
                        </div> 
                    </div>
                </div>
                <a href="" data-toggle="collapse" data-target="#demo" class="card-link">Beri komentar</a>
                <div id="demo" class="collapse">
                    <div class="mt-3">
                        <form action="/pertanyaan/{{ $pertanyaan->id }}/comment" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" placeholder="Komentarmu" id="isi" name="isi">
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-primary" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <h3>Jawaban</h3>
        @foreach ($jawaban as $key => $item)
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <p class="card-text">{!! $item->isi !!}</p>
                        <p class="card-text text-secondary" style="text-align: right"><i>{{ $item->name }} | Tanggal dibuat : {{ $item->tanggal_dibuat }}</i> </p>
                        <div class="media mx-5">
                            <div class="media-body">
                                @foreach ($komentar_j as $komentar)
                                    @if ($komentar->jawaban_id == $item->id)
                                    <hr>
                                    <p>{{$komentar->isi}} <i class="text-secondary">- oleh {{$komentar->name}} pada {{$komentar->tanggal_dibuat}}</i></p>
                                    @endif
                                @endforeach
                                <hr>
                            </div> 
                        </div>
                    </div>
                </div>
                <a href="" data-toggle="collapse" data-target="#demo{{ $item->id }}" class="card-link">Beri komentar</a>
                <div id="demo{{ $item->id }}" class="collapse">
                    <div class="mt-3">
                        <form action="/pertanyaan/{{ $pertanyaan->id }}/jawaban/{{ $item->id }}/comment" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" placeholder="Komentarmu" id="isi" name="isi">
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-primary" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mx-3 pb-3">
        <form action="/pertanyaan/{{ $pertanyaan->id }}" method="POST">
            @csrf
            <div class="form-group">
            <label for="isi"><h3>Jawabanmu :</h3></label>
            <textarea name="isi" class="form-control my-editor">{!! old('isi', $isi ?? '') !!}</textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        var editor_config = {
        path_absolute : "/",
        selector: "textarea.my-editor",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        relative_urls: false,
        file_browser_callback : function(field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
    
            var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
            if (type == 'image') {
            cmsURL = cmsURL + "&type=Images";
            } else {
            cmsURL = cmsURL + "&type=Files";
            }
    
            tinyMCE.activeEditor.windowManager.open({
            file : cmsURL,
            title : 'Filemanager',
            width : x * 0.8,
            height : y * 0.8,
            resizable : "yes",
            close_previous : "no"
            });
        }
        };
    
        tinymce.init(editor_config);
    </script>
@endpush