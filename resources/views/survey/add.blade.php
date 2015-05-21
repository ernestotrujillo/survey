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
								<li>{!! $error !!}</li>
							@endforeach
						</ul>
					</div>
				@endif

				<!-- view handling messages -->
				@include('errors.error')
				{!! Form::open(array('url' => url('/user/create'),'class'=>'form-horizontal survey-form')) !!}

                    <div class="from-group widget-box form-group col-xs-12 col-sm-10">
                        <div class="widget-header">
                            <h5 class="widget-title">Survey Information</h5>
                        </div>
                        <div class="">
                            <div class="widget-main">
                                <div class="form-group col-xs-12 col-sm-12">
                                    {!! Form::text('name', '', array('placeholder' => 'Survey name', 'class'=>'col-xs-12 col-sm-10 name')) !!}
                                </div>
                                <div class="form-group col-xs-12 col-sm-12">
                                    {!! Form::select('unit', $units, '1', array('class' => 'col-xs-12 col-sm-6 unit')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="from-group widget-box col-xs-12 col-sm-10">
                        <div class="widget-header">
                            <h5 class="widget-title">Question builder</h5>
                        </div>
                        <div class="">
                            <div class="widget-main">
                                <div class="row show-grid">
                                    <div class="col-xs-12 col-sm-3">
                                        <button data-toggle="dropdown" class="btn btn-primary btn-white dropdown-toggle" aria-expanded="true">
                                            <span>Question Type</span>
                                            <i class="ace-icon fa fa-angle-down icon-on-right"></i>
                                        </button>

                                        <ul class="dropdown-menu question-type">
                                            <li>
                                                <a href="#" data-type="1"><i class="ace-icon glyphicon glyphicon-text-width"></i> Text</a>
                                            </li>

                                            <li>
                                                <a href="#" data-type="2"><i class="ace-icon fa fa-check-square-o"></i>Multiple Selection</a>
                                            </li>

                                            <li>
                                                <a href="#" data-type="3"><i class="ace-icon fa fa-circle-o"></i>Single Selection</a>
                                            </li>
                                            <li>
                                                <a href="#" data-type="4"><i class="ace-icon glyphicon glyphicon-align-justify"></i> List</a>
                                            </li>
                                            <li>
                                                <a href="#" data-type="5"><i class="ace-icon fa fa-calendar"></i> Date</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-xs-12 col-sm-9">
                                        <label class="col-xs-10 col-sm-10 no-padding-left" for="question-name">Question</label>
                                        {!! Form::text('question-name', '', array('placeholder' => 'Type your question', 'class'=>'col-xs-10 col-sm-10')) !!}
                                    </div>
                                </div>

                                <div class="row show-grid option-form ">
                                    <div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-offset-3">
                                        <label class="col-xs-10 col-sm-10 no-padding-left" for="question-name">Options</label>
                                        {!! Form::text('option-input', '', array('id'=>'option-input', 'placeholder' => 'Type your option', 'class'=>'col-xs-9 col-sm-9')) !!}
                                        <button class="add-option btn btn-success btn-sm col-xs-1 col-sm-1">
                                            <i class="ace-icon fa fa-plus icon-only"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row show-grid">
                                    <div class="options col-xs-12 col-sm-9 col-sm-offset-3 col-md-offset-3">
                                    </div>
                                </div>
                            </div>
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

				{!! Form::close() !!}
			<!-- PAGE CONTENT ENDS -->

		</div><!-- /.col -->
	</div><!-- /.row -->
@endsection
@section('script')
    <script type="text/javascript">
        jQuery(function($) {

            //Selecting the type of question
            $('.question-type li a').on('click', function(e){
                e.preventDefault();

                var type = $(this).data("type");
                var optionForm = $('.row.option-form');
                var options = $('.row .options');
                $(options).html('');

                if ((type == 2 || type == 3 || type == 4 ) && $(optionForm).is(':not(:visible)')){
                    $(optionForm).fadeToggle('show');
                }else if((type == 1 || type == 5 ) && $(optionForm).is(':visible') ) {
                    $(optionForm).fadeToggle( "slow", function(){
                        $(this).removeClass('show');
                    });
                }
                $(".btn:first-child span").text($(this).text());
                $(".btn:first-child").val($(this).text());
            });


            //Selecting the type of question
            $('.option-form .add-option').on('click', function(e){
                e.preventDefault();

                var optiontext = $('#option-input');
                var options = $('.row .options');

                if ($(optiontext).val().length > 0){

                    var buttons = '<div>' +
                     '<input id="question-list" readonly class="col-xs-9 col-sm-9" name="question-list[]" type="text" value="'+optiontext.val()+'"/>' +
                     '<button class="remove-option btn btn-danger btn-sm col-xs-1 col-sm-1" onclick="remove_option(this)">' +
                      '<i class="ace-icon fa fa-minus icon-only"></i>' +
                       '</button>' +
                        '</div>';

                    $(options).append(buttons);
                }

                $(optiontext).val('');

            });
        });

        //Selecting the type of question
        function remove_option(option){
            $(option).closest('div').remove();
        };


    </script>
@endsection