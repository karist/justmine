@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">Existing Text Template</div>
                <div class="panel-body">					
				</div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">Preview</div>
                <div class="panel-body">
                	
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('postJquery')
    @parent
@endsection