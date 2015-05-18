@extends('layout.login')

@section('content')
	<div class="center">
		<h1>
			<i class="ace-icon fa fa-leaf green"></i>
			<span class="red">Ace</span>
			<span class="grey" id="id-text2">Application</span>
		</h1>
		<h4 class="blue" id="id-company-text">&copy; Company Name</h4>
	</div>

	<div class="space-6"></div>

	@if (session('status'))
		<div class="alert alert-success">
			{{ session('status') }}
		</div>
	@endif

	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<strong>Whoops!</strong> There were some problems with your input.<br><br>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<div class="position-relative">

		<div id="forgot-box" class="forgot-box visible widget-box no-border">
			<div class="widget-body">
				<div class="widget-main">
					<h4 class="header red lighter bigger">
						<i class="ace-icon fa fa-key"></i>
						Retrieve Password
					</h4>

					<div class="space-6"></div>
					<p>
						Enter your email and to receive instructions
					</p>

					<form role="form" method="POST" action="{{ url('/password/email') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<fieldset>
							<label class="block clearfix">
								<span class="block input-icon input-icon-right">
									<input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" />
									<i class="ace-icon fa fa-envelope"></i>
								</span>
							</label>

							<div class="clearfix">
								<button type="submit" class="width-35 pull-right btn btn-sm btn-danger">
									<i class="ace-icon fa fa-lightbulb-o"></i>
									<span class="bigger-110">Send Me!</span>
								</button>
							</div>
						</fieldset>
					</form>
				</div><!-- /.widget-main -->

				<div class="toolbar center">
					<a href="{{ url('/auth/login') }}" class="back-to-login-link">
						Back to login
						<i class="ace-icon fa fa-arrow-right"></i>
					</a>
				</div>
			</div><!-- /.widget-body -->
		</div><!-- /.forgot-box -->

	</div><!-- /.position-relative -->
@endsection
