@extends('layout.app')

@section('title', 'Editar Encuesta')

@section('breadcrumb')
	<li>
		Editar Encuesta
	</li>
@endsection

@section('content')

	<div class="page-header">
		<h1>
			Editar Encuesta
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
				{!! Form::model($survey, array('method'=>'PUT', 'url' => url('/survey/'.$survey->id), 'files'=>true, 'role'=>'form',  'class'=>'form-horizontal survey-form')) !!}
                <input type="hidden" id="surveyId" name="surveyId" value="{{ $survey->id }}">
                <input type="hidden" id="qInput" name="qInput" value="">
                <input type="hidden" id="qIdInput" name="qIdInput" value="">
                <input type="hidden" id="imgsInput" name="imgsInput" value="">
                @if (isset($questions))
                    @foreach ($questions as $question)
                        <input name="respQuestions[]" id="respQuestions" type="hidden" value='{{$question}}'>
                    @endforeach
                @endif

                @include("survey.form",['submitButtonText'=>'Modificar Encuesta'])


				{!! Form::close() !!}
			<!-- PAGE CONTENT ENDS -->

		</div><!-- /.col -->
	</div><!-- /.row -->
@endsection
@section('script')
    <script type="text/javascript">
        jQuery(function($) {
            var questions = $('input[name="respQuestions[]"]');

            if (questions.length > 0){

                $.each(questions, function( index, value ) {
                    var question = $.parseJSON($(value).val());
                    draw_question(question);
                    console.log(question);
                });


            }

            //Selecting the type of question
            $('.question-type li a').on('click', function(e){
                e.preventDefault();

                var type = $(this).data("type");
                var optionForm = $('.row.option-form');
                var options = $('.row .options-ctn');
                $(options).html('');

                if ((type == 2 || type == 3 || type == 4 ) && $(optionForm).is(':not(:visible)')){
                    $(optionForm).fadeToggle('show');
                }else if((type == 1 || type == 5 ) && $(optionForm).is(':visible') ) {
                    $(optionForm).fadeToggle( "slow", function(){
                        $(this).removeClass('show');
                    });
                }
                $(".btn:first-child span").text($(this).text());
                $(".btn:first-child").val(type);
            });

            //Selecting the type of question
            $('.option-form .add-option').on('click', function(e){
                e.preventDefault();

                var optiontext = $('#option-input');
                var options = $('.row .options-ctn');

                if ($(optiontext).val().length > 0){

                    var buttons = '<div>' +
                     '<input id="question-list" readonly class="col-xs-9 col-sm-9" name="question-list[]" type="text" value="'+optiontext.val()+'"/>' +
                     '<button class="remove-option btn btn-danger btn-sm col-xs-1 col-sm-1" onclick="remove_option(this)">' +
                      '<i class="ace-icon fa fa-minus icon-only"></i>' +
                       '</button>' +
                        '</div>';

                    $(options).append(buttons);
                }else{
                    alert('Debe ingresar una opcion');
                }
                $(optiontext).val('');

            });

            //Selecting the type of question
            $('.survey-form .add-question').on('click', function(e){
                e.preventDefault();

                var qNumber = $('.question').length + 1;
                var questionName = $('#question-name').val();
                var qContainer = $('.widget-result .widget-main');
                var qType = $('.btn-type').val();
                var answerElement = '';
                var options = $('.row .options-ctn');

                if (questionName.length > 0 && qType.length > 0){
                    var opciones = $("input[name='question-list[]']");
                    switch (qType) {
                        case '1':
                            answerElement = '<input placeholder="Type your answer" class="col-xs-12 col-sm-10 options" name="answer" type="text" value=""/>';
                            break;
                        case '2':
                            if (opciones.length > 0){
                                answerElement = get_checkboxes(qNumber,opciones);
                            }else{
                                alert('Por favor ingresa las opciones');
                            }
                            break;
                        case '3':
                            if (opciones.length > 0){
                                answerElement = get_radiobuttons(qNumber,opciones);
                            }else{
                                alert('Por favor ingresa las opciones');
                            }
                            break;
                        case '4':
                            if (opciones.length > 0){
                                answerElement = get_list(qNumber,opciones);
                            }else{
                                alert('Por favor ingresa las opciones');
                            }
                            break;
                        case '5':
                            answerElement = '<div class="input-group col-xs-12 col-sm-5">' +
                            '                  <input class="form-control date-picker" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy" />' +
                            '                     <span class="input-group-addon">' +
                            '                       <i class="fa fa-calendar bigger-110"></i>' +
                            '                      </span>' +
                            '               </div>';
                            break;
                        default:
                            answerElement = '<input placeholder="Type your answer" class="col-xs-12 col-sm-10 options" name="answer" type="text" value=""/>';
                            break;
                    }

                    var html = '<div class="row show-grid col-xs-12 col-sm-10 question" qtype='+qType+' qnumber='+qNumber+' qname="'+questionName+'">' +
                     '              <h2 class="text-muted">' +
                     '                  <span class="number">'+ qNumber +'</span>' +
                     '                  <small>' +
                     '                      <i class="ace-icon fa fa-angle-double-right"></i> ' +
                     '                      <span class="name">' + questionName + '</span>' +
                     '                  </small>' +
                     '                  <button class="remove-question pull-right btn btn-danger btn-sm col-xs-1 col-sm-1" onclick="remove_question(this)">' +
                     '                      <i class="ace-icon fa fa-minus icon-only"></i>' +
                     '                  </button>'+
                     '              </h2>' + answerElement
                     '          </div>';


                    $(qContainer).append(html);
                    $('#question-name').val('');
                    $(options).html('');
                }else{
                    alert('Ingrese una pregunta y seleccione un tipo de pregunta');
                }
            });

            $('.survey-form .create-survey').on('click', function(e){
                e.preventDefault();


                var surveyId = $('#surveyId').val();
                var surveyName = $('#survey-name').val();
                var qElements = $('.question');
                var unit = $('.unit').val();

                if (surveyName.length > 0 && qElements.length > 0 && unit.length > 0){

                    //getting images list
                    var surveyImgs = $('.surveyImgs img');

                    if (surveyImgs.length > 0 ){
                        var images = [];
                        $.each(surveyImgs, function( index, value ) {
                            images.push($(value).attr('value'));
                        });
                        var imgsInput = $('#imgsInput');
                        $(imgsInput).val(JSON.stringify(images));
                    }

                    //Getting questions
                    var questions = [];
                    var oldQuestions = [];
                    var qId,qObj,qNumber, qName, qType;

                    $.each(qElements, function( index, value ) {
                        qId = $(value).attr('qid');
                        qName = $(value).attr('qname');
                        qType = $(value).attr('qtype');

                        qObj = {};
                        qObj['id'] =qId;
                        qObj['name'] =qName;
                        qObj['type'] =qType;

                        //Getting options
                        switch (qType) {
                            case '1':
                                qObj['options'] = '';
                                break;
                            case '5':
                               qObj['options'] = '';
                                break;
                            default:
                               qObj['options'] = get_options(qNumber);
                               break;
                        }

                        if(typeof qId !='undefined' &&  qId.length > 0){
                            oldQuestions.push(qId);
                        }else{
                            questions.push(qObj);
                        }
                    });

                    var qInput = $('#qInput');
                    $(qInput).val(JSON.stringify(questions));

                    var qIdInput = $('#qIdInput');
                    $(qIdInput).val(JSON.stringify(oldQuestions));

                    $('.survey-form').submit();

                }else{
                    alert('Por favor ingrese un nombre para la encuesta, unidad y al menos una pregunta');
                }

            });

            $('#id-input-file-1 , #id-input-file-2').ace_file_input({
                no_file:'No File ...',
                btn_choose:'Choose',
                btn_change:'Change',
                droppable:false,
                onchange:null,
                thumbnail: 'true | large',
                whitelist:'gif|png|jpg|jpeg',
                blacklist:'exe|php'
                //onchange:''
                //
            });

            $('.survey-form .add-file').on('click', function(e){
                e.preventDefault();
                var inputFile = '<div class="row col-xs-12 col-sm-7">' +
                    '<button class="rem-file btn btn-danger btn-sm col-xs-1 col-sm-1" onclick="remove_file(this)">' +
                      '<i class="ace-icon fa fa-minus icon-only"></i>' +
                      '</button><input name="file[]" type="file" multiple=""/></div>';

                var parentCtn = $(this).parents('.widget-main');

                $(parentCtn).append(inputFile);

                $(parentCtn).find('input').last().ace_file_input({
                    no_file:'No File ...',
                    btn_choose:'Choose',
                    btn_change:'Change',
                    droppable:false,
                    onchange:null,
                    thumbnail: 'true | large',
                    whitelist:'gif|png|jpg|jpeg',
                    blacklist:'exe|php'
                    //onchange:''
                    //
                });


            });

            $('.survey-form a.delete-img').on('click', function(e){
                e.preventDefault();

                var parentCtn = $(this).parents('li');

                $(parentCtn).remove();
            });
        });

        //Selecting the type of question
        function remove_option(option){
            $(option).closest('div').remove();
        };

        function remove_question(question){
            $(question).closest('div').remove();
        }

        function remove_file(file){
            $(file).closest('.row').remove();
        }

        function get_checkboxes(qNumber,options){
            var html = '';
            $.each(options, function( index, value ) {
              html += '<div class="checkbox"><label>' +
                                  '    <input class="options" name="options" qnumber='+qNumber+' value='+$(value).val()+' type="checkbox" class="ace">' +
                                  '    <span class="lbl">'+$(value).val()+'</span>' +
                                  '</label></div>';
            });
            return html;
        }

        function draw_checkboxes(qNumber,options){
            var html = '';
            $.each(options, function( index, value ) {
              html += '<div class="checkbox"><label>' +
                      '    <input class="options" name="options" qnumber='+qNumber+' value='+value+' type="checkbox" class="ace">' +
                      '    <span class="lbl">'+value+'</span>' +
                      '</label></div>';
            });
            return html;
        }

        function get_radiobuttons(qNumber,options){
            var html = '';
            $.each(options, function( index, value ) {
              html += '<div class="radio"><label>' +
                                  '    <input class="options" name="options" qnumber='+qNumber+' value='+$(value).val()+' type="radio" class="ace">' +
                                  '    <span class="lbl">'+$(value).val()+'</span>' +
                                  '</label></div>';
            });
            return html;
        }

        function draw_radiobuttons(qNumber,options){
            var html = '';
            $.each(options, function( index, value ) {
              html += '<div class="radio"><label>' +
                      '    <input class="options" name="options" qnumber='+qNumber+' value='+value+' type="radio" class="ace">' +
                      '    <span class="lbl">'+value+'</span>' +
                      '</label></div>';
            });
            return html;
        }

        function get_list(qNumber,options){

            var htmlOptions = '';
            $.each(options, function( index, value ) {
              htmlOptions += '    <option class="options" value='+$(value).val()+' qnumber='+qNumber+' >'+$(value).val()+'</option>';
            });
            var html = '<select class="form-control">'+htmlOptions+'</select>';
            return html;
        }

        function draw_list(qNumber,options){

            var htmlOptions = '';
            $.each(options, function( index, value ) {
              htmlOptions += '    <option class="options" value='+value+' qnumber='+qNumber+' >'+value+'</option>';
            });
            var html = '<select class="form-control">'+htmlOptions+'</select>';
            return html;
        }

        function get_options(qNumber){

            var optElements = $(".options[qnumber="+qNumber+"]");
            if (optElements.length > 0){
                var options = [];
                $.each(optElements, function( index, value ) {
                    options.push($(value).val());
                });

                return options;
            }else{
                return '';
            }
        }

        function draw_question(question){
            var qNumber = $('.question').length + 1;
            var questionName = question.name;
            var qContainer = $('.widget-result .widget-main');
            var qId = question.id;
            var qType = question.type;
            var answerElement = '';
            var options = $('.row .options-ctn');

            if (questionName.length > 0 && qType.length > 0){
                var opciones = question.options;
                if (typeof question.options == "object" ){
                    switch (qType) {
                        case '1':
                            answerElement = '<input placeholder="Type your answer" class="col-xs-12 col-sm-10 options" name="answer" type="text" value=""/>';
                            break;
                        case '2':
                            if (typeof opciones == "object"){
                                answerElement = draw_checkboxes(qNumber,opciones);
                            }else{
                                alert('Por favor ingresa las opciones');
                            }
                            break;
                        case '3':
                            if (typeof opciones == "object"){
                                answerElement = draw_radiobuttons(qNumber,opciones);
                            }else{
                                alert('Por favor ingresa las opciones');
                            }
                            break;
                        case '4':
                            if (typeof opciones == "object"){
                                answerElement = draw_list(qNumber,opciones);
                            }else{
                                alert('Por favor ingresa las opciones');
                            }
                            break;
                        case '5':
                            answerElement = '<div class="input-group col-xs-12 col-sm-5">' +
                            '                  <input class="form-control date-picker" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy" />' +
                            '                     <span class="input-group-addon">' +
                            '                       <i class="fa fa-calendar bigger-110"></i>' +
                            '                      </span>' +
                            '               </div>';
                            break;
                        default:
                            answerElement = '<input placeholder="Type your answer" class="col-xs-12 col-sm-10 options" name="answer" type="text" value=""/>';
                            break;
                    }

                    var html = '<div class="row show-grid col-xs-12 col-sm-10 question" qId='+qId+' qtype='+qType+' qnumber='+qNumber+' qname="'+questionName+'">' +
                     '              <h2 class="text-muted">' +
                     '                  <span class="number">'+ qNumber +'</span>' +
                     '                  <small>' +
                     '                      <i class="ace-icon fa fa-angle-double-right"></i> ' +
                     '                      <span class="name">' + questionName + '</span>' +
                     '                  </small>' +
                     '                  <button class="remove-question pull-right btn btn-danger btn-sm col-xs-1 col-sm-1" onclick="remove_question(this)">' +
                     '                      <i class="ace-icon fa fa-minus icon-only"></i>' +
                     '                  </button>'+
                     '              </h2>' + answerElement
                     '          </div>';

                }
                $(qContainer).append(html);
                $(options).html('');
            }else{
                alert('Ingrese una pregunta y seleccione un tipo de pregunta');
            }
        }

    </script>
@endsection