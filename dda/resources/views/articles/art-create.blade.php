@extends('layouts.app')
@section('content')
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('js/tinymce/tinymce.min.js') }}"></script>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Buat Artikel</div>
                <div class="panel-body">
                    @if(Session::has('success'))
                        <div class="alert alert-success">
                        {!! Session::get('success') !!}
                        </div>
                    @endif
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="alert-warning">
                        @foreach( $errors->all() as $error )
                           <br> {{ $error }}
                        @endforeach
                    </div>

                    {!! Form::open(['action'=>'ArticlesController@store']) !!}

                    <div class="form-group">
                        {!! Form::label('title', 'Judul:') !!}
                        {!! Form::text('title', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('description', 'Isi:') !!}
                        {!! Form::textarea('description', null, ['class'=>'form-control', 'rows'=>5] ) !!}
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2 pull-right">
                            {!! Form::submit('Simpan Artikel', array( 'class'=>'btn btn-primary form-control pull-right' )) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                    <div class="col-sm-2 pull-right">
                        <button type="button" id="translate_btn" class="btn btn-info pull-right">Terjemahkan</button>
                    </div>

                    <a class="btn btn-default pull-right" href="{{ url('articles') }}" role="button">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    tinymce.init({
        selector: 'textarea',
        plugins: [
        "image lists spellchecker",
        ],
        toolbar1: 'bold italic underline strikethrough | subscript superscript | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | undo redo image',
        menubar: false
    });

    $('#translate_btn').on('click', function(){
        var input_text = tinyMCE.activeEditor.getContent({format : 'text'});
        if(input_text != ''){
            $.get('/ajax-translate?input_text='+ input_text, function(data){
                alert(JSON.stringify(data));
            });
        }
    });
</script>
@endsection