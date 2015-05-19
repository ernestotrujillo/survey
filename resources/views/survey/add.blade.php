@extends('layout.app')

@section('title', 'Create a new Survey')

@section('breadcrumb')
	<li>
		Create Survey
	</li>
@endsection

@section('content')

	<div class="page-header">
		<h1>
			Create Survey
		</h1>
	</div>

	<div class="row">
		<div class="col-xs-12">

			<!-- PAGE CONTENT BEGINS -->
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

				<!-- view handling messages -->
				@include('errors.error')

				<form class="form-horizontal" role="form" method="POST" action="{{ url('/user/create') }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right">Unit</label>
                        <div class="col-sm-9">
                            <?php echo Form::select('unit', $units, '1', array('class' => 'col-xs-10 col-sm-6')); ?>
                        </div>
                    </div>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right">Nombre</label>
						<div class="col-sm-9">
							<input type="text" class="col-xs-10 col-sm-6" name="firstname" value="{{ old('firstname') }}">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right">Apellido</label>
						<div class="col-sm-9">
							<input type="text" class="col-xs-10 col-sm-6" name="lastname" value="{{ old('lastname') }}">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right">Unumber</label>
						<div class="col-sm-9">
							<input type="text" class="col-xs-10 col-sm-6" name="unumber" value="{{ old('unumber') }}">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right">E-Mail</label>
						<div class="col-sm-9">
							<input type="email" class="col-xs-10 col-sm-6" name="email" value="{{ old('email') }}">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right">Password</label>
						<div class="col-sm-9">
							<input type="password" class="col-xs-10 col-sm-6" name="password">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right">Confirmar Password</label>
						<div class="col-sm-9">
							<input type="password" class="col-xs-10 col-sm-6" name="password_confirmation">
						</div>
					</div>

					<div class="clearfix form-actions">
						<div class="col-md-offset-3 col-md-9">
							<button class="btn btn-info" type="submit">
								<i class="ace-icon fa fa-check bigger-110"></i>
								Enviar
							</button>

							&nbsp; &nbsp; &nbsp;
							<button class="btn" type="reset">
								<i class="ace-icon fa fa-undo bigger-110"></i>
								Borrar
							</button>
						</div>
					</div>

				</form>
			<!-- PAGE CONTENT ENDS -->

		</div><!-- /.col -->
	</div><!-- /.row -->
@endsection
