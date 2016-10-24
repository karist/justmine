@extends('layouts/app')

@section('content')

	<head>
		<title>Hyperspace by HTML5 UP</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="{{ URL:: asset('css/main.css') }}" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	</head>
	<body>

		<!-- Sidebar -->
			<section id="sidebar">
				<div class="inner">
					<nav>
						<ul>
							<li><a href="intro">Welcome</a></li>
							<li><a href="templates">Create Table Template</a></li>
							<li><a href="two">Create Text Template</a></li>
							<li><a href="entry">Entry Table</a></li>
              <li><a href="four">Entry Text</a></li>
              <li><a href="template-json">Generate</a></li>
						</ul>
					</nav>
				</div>
			</section>

		<!-- Wrapper -->
			<div id="wrapper">
        @yield('distinct')
      </div>

		<!-- Footer -->
			<footer id="footer" class="wrapper style1-alt">
				<div class="inner">
					<ul class="menu">
						<li><p>Copyright &copy; 2016 Sekolah Tinggi Ilmu Statistik</p></li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
					</ul>
				</div>
			</footer>

		<!-- Scripts -->
			<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
			<script src="{{ URL::asset('js/jquery.scrollex.min.js') }}"></script>
			<script src="{{ URL::asset('js/jquery.scrolly.min.js') }}"></script>
			<script src="{{ URL::asset('js/skel.min.js') }}"></script>
			<script src="{{ URL::asset('js/util.js') }}"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="{{ URL::asset('js/main.js') }}"></script>
<!-- 
			<script type="text/javascript" src="{{ URL::asset('js/templatejson.js') }}"></script>
			<script type="text/javascript" src="{{ URL::asset('js/addremovefield.js') }}"></script>
			<script type="text/javascript" src="{{ URL::asset('js/jquery-2.2.1.js') }}"></script>
			<script type="text/javascript" src="{{ URL::asset('js/jquery-ui.js') }}"></script>
			<script type="text/javascript" src="{{ URL::asset('js/dialog.js') }}"></script>
			<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/createtab.css') }}">
			<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/dialog.css') }}">
			<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/jquery-ui.css') }}"> -->
@stop
