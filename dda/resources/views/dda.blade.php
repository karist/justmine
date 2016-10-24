<style>
.carousel-inner > .item > img,
.carousel-inner > .item > a > img {
  width: 70%;
  margin: auto;
}

#pdfViewer{
  width: 148mm;
  height: 210mm;
}
</style>

@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
      <div class="col-md-12">
          <div class="panel panel-default">
              <div class="panel-heading">Publikasi DDA</div>
              <div class="panel-body">
                <table class="table table-bordered table-hover tableList category-table" data-toggle="dataTable" data-form="deleteForm">
                    <tbody>
                        @foreach($files as $file)
                            <tr id = "{{ (string)$file }}">
                                <td>{{ (string)$file }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
		          </div>
          </div>
      </div>
      <div class="col-md-12">
          <div class="panel panel-default">
              <div class="panel-heading">Pratinjau</div>
              <div class="panel-body">
                <div class="center-block" align="middle">
                  <object id="pdfViewer" data="{{ asset('published/2016-09-02-10-48-46-3201_2015.pdf') }}" type="application/pdf" height="100%" width="100%">
                    <p><b>Example fallback content</b>: This browser does not support PDFs. Please download the PDF to view it: <a href="{{ asset('published/2016-09-02-10-48-46-3201_2015.pdf#page=2') }}">Download PDF</a>.</p>
                  </object>
                </div>
              </div>
          </div>
      </div>
    </div>
</div>

@endsection
@section('postJquery')
  $('tr').click(function(){
    var filePath = $(this).attr('id');
    $('#pdfViewer').attr('data', filePath);
  });
@endsection