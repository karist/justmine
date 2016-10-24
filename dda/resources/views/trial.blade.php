@extends('layouts.app')
@section('content')
<style>
* {
  .border-radius(0) !important;
}

#field {
    margin-bottom:20px;
}
</style>
<div class="container">
    <div class="row">
      <div class="container">
        <div class="row">
          <input type="hidden" name="count" value="1" />
            <div class="control-group" id="fields">
              <label class="control-label" for="field1">Nice Multiple Form Fields</label>
                <div class="controls" id="profs"> 
                  <form class="input-append">
                    <div id="field">
                      <button id="b1" class="btn add-more" type="button">+</button>
                      <ol>
                      <li><textarea rows="4" cols="50" class="input form-control" id="field1" name="prof1" placeholder="Type something"></textarea></li>
                      <!-- <input autocomplete="off" class="input" id="field1" name="prof1" type="text"  data-items="8"/> -->
                      </ol>
                    </div>
                  </form>
              <br>
            <small>Press + to add another form field :)</small>
          </div>
        </div>
      </div>
    </div>
        <!-- <form name="codexworld_frm" method="post" class="form-horizontal" role="form">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="button" id="click_me" name="click_me">
          <input type="text" id="target" name="target">
          <div class="form-group">
              <label class="control-label col-sm-2" for="stub_detail">Detail Stub:</label>
              <div class="col-sm-10">
                <a class="add_button" title="Add field" id="add">Add More Input Field</a>
                <div class="scrollbar">
                    <div class="force-overflow">
                        <div class="field_wrapper">
                        </div>
                    </div>
                </div>
              </div>
          </div>
        <button type="submit" class="btn btn-primary pull-right" id="stub_save" value="Save Stub">Save</button>
        </form> -->
    </div>
</div>
<script type="text/javascript" src="{{ URL::asset('js/jquery-2.2.1.js') }}"></script>
<script src="{{ URL::asset('js/addremovefield.js') }}"></script>
<script src="{{ URL::asset('js/trial.js') }}"></script>
@endsection