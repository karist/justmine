@extends('layouts.app')
<head>
    <title>creDDAtor | Admin</title>
    <style type="text/css">
        .mini-submenu{
          display:none;  
          background-color: rgba(0, 0, 0, 0);  
          border: 1px solid rgba(0, 0, 0, 0.9);
          border-radius: 4px;
          padding: 9px;  
          /*position: relative;*/
          width: 42px;

        }

        .mini-submenu:hover{
          cursor: pointer;
        }

        .mini-submenu .icon-bar {
          border-radius: 1px;
          display: block;
          height: 2px;
          width: 22px;
          margin-top: 3px;
        }

        .mini-submenu .icon-bar {
          background-color: #000;
        }

        #slide-submenu{
          background: rgba(0, 0, 0, 0.45);
          display: inline-block;
          padding: 0 8px;
          border-radius: 4px;
          cursor: pointer;
        }
    </style>
</head>
@section('content')
<head>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('font-awesome/css/font-awesome.css') }}">
</head>
<!-- <div class="container"> -->
    <div class="row">
        <div class="col-sm-4 col-md-3 sidebar">
            <div class="mini-submenu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </div>
            <div class="list-group">
                <span href="#" class="list-group-item active">
                    Administrator
                    <span class="pull-right" id="slide-submenu">
                        <i class="fa fa-times"></i>
                    </span>
                </span>
                <a href="{{ url('admin/dda') }}" class="list-group-item">
                    <i class="glyphicon glyphicon-book"></i> DDA
                </a>
                <a href="{{ url('admin/bab') }}" class="list-group-item">
                    <i class="glyphicon glyphicon-book"></i> Bab
                </a>
                <a href="{{ url('admin/daerah') }}" class="list-group-item">
                    <i class="glyphicon glyphicon-book"></i> Berkas Induk Daerah
                </a>
                <a href="{{ url('admin/baku') }}" class="list-group-item">
                    <i class="glyphicon glyphicon-book"></i> Tabel Baku
                </a>
                <a href="{{ url('admin/templates') }}" class="list-group-item">
                    <i class="glyphicon glyphicon-book"></i> Templat Tabel
                </a>
                <a href="{{ url('admin/user') }}" class="list-group-item">
                    <i class="fa fa-user"></i> Atur Pengguna <span class="badge">{{ $count }}</span>
                </a>
                <a href="{{ url('admin/register') }}" class="list-group-item">
                    <i class="fa fa-user-plus"></i> Tambah Pengguna
                </a>
            </div>        
        </div>
        <div class="col-sm-8 col-md-9 sidebar">
            <div class="panel panel-default">
                 @yield('contentAdmin')
            </div>
        </div>
    </div>
<!-- </div> -->
@endsection

@section('postJquery')
    $('#slide-submenu').on('click',function() {                 
        $(this).closest('.list-group').fadeOut('slide',function(){
            $('.mini-submenu').fadeIn();    
        });
        
      });

    $('.mini-submenu').on('click',function(){       
        $(this).next('.list-group').toggle('slide');
        $('.mini-submenu').hide();
    });
@endsection