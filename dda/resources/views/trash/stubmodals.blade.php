<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create a New Stub</h4>
      </div>
      <div class="modal-body">
      @if(Session::has('success'))
        {!! Session::get('success') !!}
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
        <form name="codexworld_frm" action="{{ url('create') }}" method="post" class="form-horizontal" role="form">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
              <label class="control-label col-sm-2" for="stub_nama">Nama Stub:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="stub_nama" id="stub_nama">
              </div>
          </div>
          <div class="form-group">
              <label class="control-label col-sm-2" for="stub_label">Label Stub:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="stub_label" id="stub_label">
              </div>
          </div>
          <div class="form-group">
              <label class="control-label col-sm-2" for="stub_english">Label Stub:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="stub_english" id="stub_english">
              </div>
          </div>
          <div class="form-group">
              <label class="control-label col-sm-2" for="stub_detail">Detail Stub:</label>
              <div class="col-sm-10">
                <a class="add_button" title="Add field" id="add">Add More Input Field</a>
                <div class="scrollbar">
                    <div class="force-overflow">
                        <div class="field_wrapper">
                            <div>
                              <div class="col-sm-5">
                                <input placeholder="Istiah dalam Bahasa" type="text" class="form-control" name="field_indo[]"/>
                              </div>
                              <div class="col-sm-5">
                                <input placeholder="English Term" type="text" class="form-control" name="field_eng[]"/>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="stub_save" value="Save Stub">Save</button>
        </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>