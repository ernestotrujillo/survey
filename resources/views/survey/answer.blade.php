@extends('layout.app')

@section('title', 'Crear Cuenta')

@section('breadcrumb')
    <li>
        Encuesta
    </li>
@endsection

@section('content')

    <div class="page-header">
        <h1>
            Encuesta
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

            @include('errors.error')

            @include('errors.error')

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/user') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                @if (isset($questions))
                    @foreach ($questions as $question)
                        <input name="respQuestions[]" id="respQuestions" type="hidden" value='{{$question}}'>
                    @endforeach
                @endif

                <div class="row">
                    <div class="questions-list col-md-8 col-md-offset-2">

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

@section('script')
    <script type="text/javascript">
        jQuery(function($) {

            var questions = $('input[name="respQuestions[]"]');

            if (questions.length > 0){

                $.each(questions, function( index, value ) {
                    var question = $.parseJSON($(value).val());
                    draw_question(question);
                });


            }

            function draw_checkboxes(qNumber,options){
                var html = '';
                $.each(options, function( index, value ) {
                    html += '<div class="checkbox"><label>' +
                    '    <input class="options" name="options" qnumber='+qNumber+' value='+index+' type="checkbox" class="ace">' +
                    '    <span class="lbl">'+value+'</span>' +
                    '</label></div>';
                });
                return html;
            }

            function draw_radiobuttons(qNumber,options){
                var html = '';
                $.each(options, function( index, value ) {
                    html += '<div class="radio"><label>' +
                    '    <input class="options" name="options" qnumber='+qNumber+' value='+index+' type="radio" class="ace">' +
                    '    <span class="lbl">'+value+'</span>' +
                    '</label></div>';
                });
                return html;
            }

            function draw_list(qNumber,options){

                var htmlOptions = '';
                $.each(options, function( index, value ) {
                    htmlOptions += '    <option class="options" value='+index+' qnumber='+qNumber+' >'+value+'</option>';
                });
                var html = '<select class="form-control">'+htmlOptions+'</select>';
                return html;
            }

            function draw_question(question){
                var qNumber = $('.question').length + 1;
                var questionName = question.name;
                var qContainer = $('.questions-list');
                var qType = question.type;
                var answerElement = '';
                var options = $('.row .options-ctn');
                var qId = question.id;

                if (questionName.length > 0 && qType.length > 0){
                    var opciones = question.options;
                    if (typeof question.options == "object" ){
                        switch (qType) {
                            case '1':
                                answerElement = '<input class="col-xs-12 col-sm-12 options" name="answer" type="text" value=""/>';
                                break;
                            case '2':
                                if (typeof opciones == "object"){
                                    answerElement = draw_checkboxes(qNumber,opciones);
                                }
                                break;
                            case '3':
                                if (typeof opciones == "object"){
                                    answerElement = draw_radiobuttons(qNumber,opciones);
                                }
                                break;
                            case '4':
                                if (typeof opciones == "object"){
                                    answerElement = draw_list(qNumber,opciones);
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
                                answerElement = '<input class="col-xs-12 col-sm-12 options" name="answer" type="text" value=""/>';
                                break;
                        }

                        var html = '<div class="row show-grid col-xs-12 col-sm-12 question" qid='+qId+' qtype='+qType+' qnumber='+qNumber+' qname="'+questionName+'">' +
                                '              <h2 class="text-muted">' +
                                '                  <span class="number">'+ qNumber +'</span>' +
                                '                  <small>' +
                                '                      <i class="ace-icon fa fa-angle-double-right"></i> ' +
                                '                      <span class="name">' + questionName + '</span>' +
                                '                  </small>' +
                                '              </h2>' + answerElement
                        '          </div>';

                    }
                    $(qContainer).append(html);
                    $(options).html('');
                }else{
                    alert('Ingrese una pregunta y seleccione un tipo de pregunta');
                }
            }

        });
    </script>
@endsection