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

	<!-- text fonts -->
	<link rel="stylesheet" href="{{ asset('/css/ace-fonts.css') }}" />

	<!-- ace styles -->
	<link rel="stylesheet" href="{{ asset('/css/ace.css') }}" class="ace-main-stylesheet" id="main-ace-style" />

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
			<ul class="nav ace-nav">
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
								Profile
							</a>
						</li>

						<li class="divider"></li>

						<li>
							<a href="{{ url('logout') }}">
								<i class="ace-icon fa fa-power-off"></i>
								Logout
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
						<a href="{{ url('/') }}">Home</a>
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
				<!-- #section:settings.box -->
				<div class="ace-settings-container" id="ace-settings-container">
					<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
						<i class="ace-icon fa fa-cog bigger-130"></i>
					</div>

					<div class="ace-settings-box clearfix" id="ace-settings-box">
						<div class="pull-left width-50">
							<!-- #section:settings.skins -->
							<div class="ace-settings-item">
								<div class="pull-left">
									<select id="skin-colorpicker" class="hide">
										<option data-skin="no-skin" value="#438EB9">#438EB9</option>
										<option data-skin="skin-1" value="#222A2D">#222A2D</option>
										<option data-skin="skin-2" value="#C6487E">#C6487E</option>
										<option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
									</select>
								</div>
								<span>&nbsp; Choose Skin</span>
							</div>

							<!-- /section:settings.skins -->

							<!-- #section:settings.navbar -->
							<div class="ace-settings-item">
								<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
								<label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
							</div>

							<!-- /section:settings.navbar -->

							<!-- #section:settings.sidebar -->
							<div class="ace-settings-item">
								<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
								<label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
							</div>

							<!-- /section:settings.sidebar -->

							<!-- #section:settings.breadcrumbs -->
							<div class="ace-settings-item">
								<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
								<label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
							</div>

							<!-- /section:settings.breadcrumbs -->

							<!-- #section:settings.rtl -->
							<div class="ace-settings-item">
								<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
								<label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
							</div>

							<!-- /section:settings.rtl -->

							<!-- #section:settings.container -->
							<div class="ace-settings-item">
								<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
								<label class="lbl" for="ace-settings-add-container">
									Inside
									<b>.container</b>
								</label>
							</div>

							<!-- /section:settings.container -->
						</div><!-- /.pull-left -->

						<div class="pull-left width-50">
							<!-- #section:basics/sidebar.options -->
							<div class="ace-settings-item">
								<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" />
								<label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
							</div>

							<div class="ace-settings-item">
								<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" />
								<label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
							</div>

							<div class="ace-settings-item">
								<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" />
								<label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
							</div>

							<!-- /section:basics/sidebar.options -->
						</div><!-- /.pull-left -->
					</div><!-- /.ace-settings-box -->
				</div><!-- /.ace-settings-container -->
				<!-- /section:settings.box -->

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
	{{--<script src="{{ asset('/js/dropzone.js') }}"></script>--}}

	<!-- inline scripts related to this page -->
	@yield('script')

</body>
</html>
