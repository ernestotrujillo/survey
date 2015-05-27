<?php $user_session = session('user'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title>@yield('title')</title>

	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

	<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="{{ asset('/css/bootstrap.css') }}" />
	<link rel="stylesheet" href="{{ asset('/css/font-awesome.css') }}" />

	<link rel="stylesheet" href="{{ asset('/css/colorbox.css') }}" />

	<!-- text fonts -->
	<link rel="stylesheet" href="{{ asset('/css/ace-fonts.css') }}" />

	<!-- ace styles -->
	<link rel="stylesheet" href="{{ asset('/css/ace.css') }}" class="ace-main-stylesheet" id="main-ace-style" />

	<link rel="stylesheet" href="{{ asset('/css/datepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/dropzone.css') }}" />

	<!--[if lte IE 9]>
	<link rel="stylesheet" href="{{ asset('/css/ace-part2.css') }}" class="ace-main-stylesheet" />
	<![endif]-->

	<!--[if lte IE 9]>
	<link rel="stylesheet" href="{{ asset('/css/ace-ie.css') }}" />
	<![endif]-->

	<!-- inline styles related to this page -->

	<!-- ace settings handler -->
	<script src="{{ asset('/js/ace-extra.js') }}"></script>

	<link rel="stylesheet" href="{{ asset('/css/style.css') }}" />

	<!--link href="{{ asset('/css/app.css') }}" rel="stylesheet"-->

	<!-- Fonts -->
	<!--link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="{{ asset('/js/html5shiv.js') }}"></script>
	<script src="{{ asset('/js/respond.js') }}"></script>
	<![endif]-->
</head>

<body class="no-skin">

<!-- #section:basics/navbar.layout -->
<div id="navbar" class="navbar navbar-default">
	<script type="text/javascript">
		try{ace.settings.check('navbar' , 'fixed')}catch(e){}
	</script>

	<div class="navbar-container" id="navbar-container">
		<!-- #section:basics/sidebar.mobile.toggle -->
		<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
			<span class="sr-only">Toggle sidebar</span>

			<span class="icon-bar"></span>

			<span class="icon-bar"></span>

			<span class="icon-bar"></span>
		</button>

		<!-- /section:basics/sidebar.mobile.toggle -->
		<div class="navbar-header pull-left">
			<!-- #section:basics/navbar.layout.brand -->
			<a href="{{ url('/') }}" class="navbar-brand">
				<small>
					<i class="fa fa-leaf"></i>
					Ace Admin
				</small>
			</a>

			<!-- /section:basics/navbar.layout.brand -->

			<!-- #section:basics/navbar.toggle -->

			<!-- /section:basics/navbar.toggle -->
		</div>

		<!-- #section:basics/navbar.dropdown -->
		<div class="navbar-buttons navbar-header pull-right" role="navigation">
			<ul class="nav custom-nav">
				<!-- #section:basics/navbar.user_menu -->
				<li class="light-blue">
					<a data-toggle="dropdown" href="#" class="dropdown-toggle">
						<span class="user-info">
							<small>Bienvenido,</small>
							{{ Auth::user()->firstname }}
						</span>
						<i class="ace-icon fa fa-caret-down"></i>
					</a>

					<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
						<li>
							<a href="{{ url('/profile') }}">
								<i class="ace-icon fa fa-user"></i>
								Cuenta
							</a>
						</li>

						<li class="divider"></li>

						<li>
							<a href="{{ url('logout') }}">
								<i class="ace-icon fa fa-power-off"></i>
								Salir
							</a>
						</li>
					</ul>
				</li>

				<!-- /section:basics/navbar.user_menu -->
			</ul>
		</div>

		<!-- /section:basics/navbar.dropdown -->
	</div><!-- /.navbar-container -->
</div>

<!-- /section:basics/navbar.layout -->
<div class="main-container" id="main-container">
	<script type="text/javascript">
		try{ace.settings.check('main-container' , 'fixed')}catch(e){}
	</script>

	<!-- #section:basics/sidebar -->
	@include('layout.sidebar')
	<!-- /section:basics/sidebar -->

	<div class="main-content">
		<div class="main-content-inner">
			<!-- #section:basics/content.breadcrumbs -->
			<div class="breadcrumbs" id="breadcrumbs">
				<script type="text/javascript">
					try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
				</script>

				<ul class="breadcrumb">
					<li>
						<i class="ace-icon fa fa-home home-icon"></i>
						<a href="{{ url('/') }}">Inicio</a>
					</li>

					@yield('breadcrumb')

				</ul><!-- /.breadcrumb -->

				<!-- #section:basics/content.searchbox -->
				<div class="nav-search" id="nav-search">
					<form class="form-search">
						<span class="input-icon">
							<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
							<i class="ace-icon fa fa-search nav-search-icon"></i>
						</span>
					</form>
				</div><!-- /.nav-search -->

				<!-- /section:basics/content.searchbox -->
			</div>

			<!-- /section:basics/content.breadcrumbs -->
			<div class="page-content">

				@yield('content')

			</div><!-- /.page-content -->
		</div>
	</div><!-- /.main-content -->

	<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
		<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
	</a>
</div><!-- /.main-container -->

	<!-- basic scripts -->

	<!--[if !IE]> -->
	<script type="text/javascript">
		window.jQuery || document.write("<script src='{{ asset('/js/jquery.js') }}'>"+"<"+"/script>");
	</script>

	<!-- <![endif]-->

	<!--[if IE]>
	<script type="text/javascript">
		window.jQuery || document.write("<script src='{{ asset('/js/jquery1x.js') }}'>"+"<"+"/script>");
	</script>
	<![endif]-->
	<script type="text/javascript">
		if('ontouchstart' in document.documentElement) document.write("<script src='{{ asset('/js/jquery.mobile.custom.js') }}'>"+"<"+"/script>");
	</script>

	<script src="{{ asset('/js/bootstrap.js') }}"></script>

	<!-- page specific plugin scripts -->
    <script src="{{ asset('/js/jquery.colorbox.js') }}"></script>
	<!-- ace scripts -->
	<script src="{{ asset('/js/ace/elements.scroller.js') }}"></script>
	<script src="{{ asset('/js/ace/elements.colorpicker.js') }}"></script>
	<script src="{{ asset('/js/ace/elements.fileinput.js') }}"></script>
	<script src="{{ asset('/js/ace/elements.typeahead.js') }}"></script>
	<script src="{{ asset('/js/ace/elements.wysiwyg.js') }}"></script>
	<script src="{{ asset('/js/ace/elements.spinner.js') }}"></script>
	<script src="{{ asset('/js/ace/elements.treeview.js') }}"></script>
	<script src="{{ asset('/js/ace/elements.wizard.js') }}"></script>
	<script src="{{ asset('/js/ace/elements.aside.js') }}"></script>
	<script src="{{ asset('/js/ace/ace.js') }}"></script>
	<script src="{{ asset('/js/ace/ace.ajax-content.js') }}"></script>
	<script src="{{ asset('/js/ace/ace.touch-drag.js') }}"></script>
	<script src="{{ asset('/js/ace/ace.sidebar.js') }}"></script>
	<script src="{{ asset('/js/ace/ace.sidebar-scroll-1.js') }}"></script>
	<script src="{{ asset('/js/ace/ace.submenu-hover.js') }}"></script>
	<script src="{{ asset('/js/ace/ace.widget-box.js') }}"></script>
	<script src="{{ asset('/js/ace/ace.settings.js') }}"></script>
	<script src="{{ asset('/js/ace/ace.settings-rtl.js') }}"></script>
	<script src="{{ asset('/js/ace/ace.settings-skin.js') }}"></script>
	<script src="{{ asset('/js/ace/ace.widget-on-reload.js') }}"></script>
	<script src="{{ asset('/js/ace/ace.searchbox-autocomplete.js') }}"></script>
	<script src="{{ asset('/js/ace/date-time/bootstrap-datepicker.js') }}"></script>
	{{--<script src="{{ asset('/js/dropzone.js') }}"></script>--}}

	<!-- inline scripts related to this page -->
	@yield('script')

</body>
</html>
