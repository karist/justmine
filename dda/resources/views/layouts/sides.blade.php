<link rel="stylesheet" href="{{ URL:: asset('css/sides.css') }}" />
@extends('layouts/app')

@section('content')
  <div id="leftside">
    @yield('leftside')
  </div>
  <div id="main">
    @yield('main')
  </div>
  <div class="rightside">
    @yield('rightside')
  </div>
@stop
