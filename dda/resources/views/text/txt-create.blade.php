@extends('layouts.app')
@section('content')
<script type="text/javascript" src="{{ URL::asset('js/jquery-2.2.1.js') }}"></script>
<script src="{{ URL::asset('js/jquery-ui.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/form-builder.css') }}">

<a type="button" class="btn btn-default pull-left" id="back" value="Back" href="{{ url('text') }}">Back</a>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading"></div>
                <div class="panel-body"><textarea id="fb-template"></textarea></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">Existing Text Template</div>
                <div class="panel-body">
                    <ul class="list-group">
                        <li class="list-group-item">Cras justo odio</li>
                        <li class="list-group-item">Dapibus ac facilisis in</li>
                        <li class="list-group-item">Morbi leo risus</li>
                        <li class="list-group-item">Porta ac consectetur ac</li>
                        <li class="list-group-item">Vestibulum at eros</li>
                        <li class="list-group-item">Cras justo odio</li>
                        <li class="list-group-item">Dapibus ac facilisis in</li>
                        <li class="list-group-item">Morbi leo risus</li>
                        <li class="list-group-item">Porta ac consectetur ac</li>
                        <li class="list-group-item">Vestibulum at eros</li>
                    </ul>                   
                </div>
            </div>
        </div>
    </div>
</div>  
<script src="{{ URL::asset('js/form-builder.js') }}"></script>

<script>
jQuery(document).ready(function($) {
    'use strict';
    $(document.getElementById('fb-template')).formBuilder();
});
</script>
@endsection

@section('postJquery')
    @parent
@endsection