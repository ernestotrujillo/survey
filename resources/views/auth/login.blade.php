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

	@if (count($errors) > 0)
		<div class="alert alert-danger">
			Exíste un problema en el envío del formulario.<br><br>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<div class="position-relative">
		<div id="login-box" class="login-box visible widget-box no-border">
			<div class="widget-body">
				<div class="widget-main">
					<h4 class="header blue lighter bigger">
						<i class="ace-icon fa fa-coffee green"></i>
						Por favor! Introduzca sus datos
					</h4>

					<div class="space-6"></div>

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<fieldset>

							<label class="block clearfix">
								<span class="block input-icon input-icon-right">
									<input type="text" class="form-control" name="unumber" placeholder="Unumber" value="{{ old('unumber') }}">
									<i class="ace-icon fa fa-user"></i>
								</span>
							</label>

							<label class="block clearfix">
								<span class="block input-icon input-icon-right">
									<input type="password" class="form-control" name="password" placeholder="Password">
									<i class="ace-icon fa fa-lock"></i>
								</span>
							</label>

							<div class="space"></div>

							<div class="clearfix">
								<label class="inline">
									<input class="ace" type="checkbox" name="remember" />
									<span class="lbl"> Recuerdame</span>
								</label>

								<button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
									<i class="ace-icon fa fa-key"></i>
									<span class="bigger-110">Entrar</span>
								</button>

							</div>

							<div class="space-4"></div>
						</fieldset>
					</form>

				</div><!-- /.widget-main -->

				<div class="toolbar clearfix">
					<div>
						<a href="{{ url('/password/email') }}" class="forgot-password-link">
							<i class="ace-icon fa fa-arrow-left"></i>
							Olvidé mi contraseña
						</a>
					</div>
				</div>
			</div><!-- /.widget-body -->
		</div><!-- /.login-box -->

	</div><!-- /.position-relative -->

@endsection
