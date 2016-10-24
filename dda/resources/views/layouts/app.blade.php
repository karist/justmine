<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>creDDAtor</title>

    <!-- Fonts -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('font-awesome/css/font-awesome.min.css') }}">

    <!-- Styles -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"> -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    

    <style>
        body {
       /*     background: url('images/bg.jpg');*/
            font-family: 'Lato';
            padding-top : 60px;
            height:100%;
        }

        .scrollbar{
            width: 100%;
            height: 250px;
            overflow: scroll;
        }

        .table-hover>tbody>tr:hover>td,.table-hover>tbody>tr:hover>th{
            /*background-color:#f5f5f5*/
            background-color: #C6E2FF;
        }

        .btn{
            margin: 5px;
        }

        .fa-btn {
            margin-right: 6px;
        }

        .highlight { background-color: #C6E2FF; }

/*        .active {
            background: navy;
        }*/

        footer {
            /*position: relative;*/
/*            margin-top: -150px;  negative value of footer height 
            height: 150px;*/
            clear:both;
            /*padding-top:20px;*/
        }

    </style>
</head>
<body id="app-layout">
    <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    creDDAtor
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    
                    

                    @if (Auth::guest())
                    <li><a href="{{ url('dda') }}">DDA</a></li>
                    <li><a href="{{ url('articles') }}">Artikel</a></li>
                    @else
                    <li><a href="{{ url('home') }}">Beranda</a></li>
                    <li><a href="{{ url('articles') }}">Artikel</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Komponen<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            @if(Auth::user()->isAdmin)<li><a href="{{ url('admin/baku') }}">Format Tabel</a></li>@endif
                            <li><a href="{{ url('stubs') }}">Stub</a></li>
                            <li><a href="{{ url('templates') }}">Templat Tabel</a></li>
                            <!-- <li><a href="{{ url('form') }}">Tata Letak</a></li> -->
                            <!-- <li><a href="{{ url('image/create') }}">Unggah</a></li> -->
                            <!-- <li><a href="{{ url('image') }}">Images</a></li> -->
                            <!-- <li><a href="{{ url('project') }}">Project</a></li> -->
                            <!-- <li><a href="{{ url('text') }}">Text Template</a></li> -->
                            
                        </ul>
                    </li>
                    <!-- <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Create DDA<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('templates/create') }}">Create Table Templates</a></li>
                            <li><a href="{{ url('text/create') }}">Create Text Templates</a></li>
                            <li><a href="{{ url('layout/create') }}">Create Layout Templates</a></li>
                            <li><a href="{{ url('entry') }}">Entry Table</a></li>
                            <li><a href="">Entry Text</a></li>
                            <!-- <li><a href="{{ url('dda/six') }}">Create Descriptive Analysis</a></li> -->
                            <!-- <li><a href="">Generate Publication</a></li> -->
                        <!-- </ul> -->
                    <!-- </li> -->
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Masuk</a></li>
                        <!-- <li><a href="{{ url('/register') }}">Register</a></li> -->
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="position:relative; padding-left: 50px">
                                <img src="avatar/{{ Auth::user()->avatar }}" style="width:32px; height:32px; position:absolute; top:10px; left:10px; border-radius:50%">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/profile') }}"><i class="fa fa-btn fa-user"></i>Profil</a></li>
                                @if (Auth::user()->isAdmin)
                                    <li><a href="{{ url('/admin') }}"><i class="fa fa-btn fa-user-secret"></i>Halaman Administrator</a></li>
                                @endif
                                <li><a href="{{ url('/petunjuk') }}"><i class="fa fa-btn fa-info"></i>Petunjuk</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Keluar</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <!-- JavaScripts -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script> -->
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    
    <script src="{{ URL::asset('js/jquery-ui.js') }}"></script>
    <script src="{{ URL::asset('js/jsonTable.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/tableManager.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/jquery.table2excel.min.js') }}"></script>
    <script>
        jQuery(document).ready(function(){
            @yield('postJquery');
            // $('.list-group li').click(function(e) {
            //     e.preventDefault()
                
            //     $that = $(this);
                
            //     $that.parent().find('li').removeClass('active');
            //     $that.addClass('active');
            // });
            $(".tableList tr").click(function() {
                var selected = $(this).hasClass("highlight");
                $(".tableList tr").removeClass("highlight");
                if(!selected)
                        $(this).addClass("highlight");
            });
        });
    </script>

    <footer class="footer">
      <div class="container">
        <p class="text-muted">Copyright © 2016 Sekolah Tinggi Ilmu Statistik</p>
      </div>
    </footer>
    </body>
</html>
