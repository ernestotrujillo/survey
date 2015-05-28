@extends('layout.app')

@section('title', 'Crear Usuario')

@section('breadcrumb')
	<li>
		Crear Usuario
	</li>
@endsection

@section('content')

	<div class="page-header">
		<h1>
			Crear Usuario
		</h1>
	</div>

	<div class="row">
		<div class="col-xs-12">

			<!-- PAGE CONTENT BEGINS -->
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

				<!-- view handling messages -->
				@include('errors.error')

				<form class="form-horizontal" role="form" method="POST" action="{{ url('/user') }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">

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
						<label class="col-sm-3 control-label no-padding-right">Numero de Empleado</label>
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
						<label class="col-sm-3 control-label no-padding-right">Contraseña</label>
						<div class="col-sm-9">
							<input type="password" class="col-xs-10 col-sm-6" name="password">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right">Confirmar Contraseña</label>
						<div class="col-sm-9">
							<input type="password" class="col-xs-10 col-sm-6" name="password_confirmation">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right">Tipo de cuenta</label>
						<div class="col-sm-9">
							<?php echo Form::select('role', array('' => '-- Seleccione --') +$roles, '',array('class' => 'account-type-select col-xs-10 col-sm-6')); ?>
						</div>
					</div>

					<div class="form-group hidden units-input-wrap">
						<label class="col-sm-3 control-label no-padding-right">Unidad</label>
						<div class="col-sm-9">
							<?php echo Form::select('unit', array('' => '-- Seleccione --') + $units, '',array('class' => 'units-select col-xs-10 col-sm-6')); ?>
						</div>
					</div>

					<div class="form-group hidden area-input-wrap">
						<label class="col-sm-3 control-label no-padding-right">Area</label>
						<div class="area-input-div col-sm-9"></div>
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

@section('script')
	<script type="text/javascript">
		jQuery(function($) {

			if($('.account-type-select').val() > 0 && $('.account-type-select').val() < 4){
				$('.units-input-wrap').removeClass('hidden')
			}

			if($('.units-select').val() > 0){
				$('.units-select').val('');
			}

			$('.account-type-select').on('change', function() {
				var account_type = $(this).val();
				if(account_type == 1 || account_type == 2) {
					$('.units-select').val('').trigger('change');
					$('.units-input-wrap').removeClass('hidden');
				}else if(account_type == 3){
					$('.units-select').val('').trigger('change');
					$('.units-input-wrap').removeClass('hidden');
				}else{
					$('.units-select').val('').trigger('change');
					$('.units-input-wrap').addClass('hidden');
				}
			});

			$('.units-select').on('change', function() {
				var unit = $(this).val();
				var account_type = $('.account-type-select').val();
				if(unit > 0 && (account_type == 1 || account_type == 2)){

					$.ajax({
						method: "GET",
						url: "{{ URL::to('/') }}/area/filter/unit/"+unit,
						success: function(areas) {
							var html = '<select class="areas-select col-xs-10 col-sm-6" name="area">';
							html += '<option value="" selected="selected">-- Seleccione --</option>';
							$.each(areas, function( index, value ) {
								html += '<option value="'+index+'">'+value+'</option>';
							});
							html += '</select>';
							$('.area-input-div').html(html)
							$('.area-input-wrap').removeClass('hidden');
						},
						error: function(data) {
							alert('Disculpe. Hay un error para obtener las areas de esta unidad.')
						}
					});

				}else{
					$('.area-select').val('');
					$('.area-input-wrap').addClass('hidden');
				}
			});

		});
	</script>
@endsection