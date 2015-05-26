@extends('layout.app')

@section('title', 'Responder Encuesta')

@section('breadcrumb')
    <li>
        Responder Encuesta
    </li>
@endsection

@section('content')

    <div class="page-header">
        <h1>
            <?php if(isset($survey)) echo $survey->name; ?>
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
            <a class="verGaleria" href="#">Ver galeria</a>
            <form class="form-horizontal answer-view-form" role="form" method="POST" action="">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="survey_id" value="<?php echo $survey->id; ?>">

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

            // ==================== GALLERY FUNCTIONS ===============
            $('a.verGaleria').on("click", function(e){
                e.preventDefault();
                var imgs = $('a.survImg');
                if (typeof imgs !="undefined" && imgs.length > 0){
                    $('a.survImg').first().trigger('click')
                }else{
                    alert('No hay galeria de imagenes');
                }
            });

            var surveyId = $("input[name='survey_id']").val();
            if (typeof surveyId !="undefined" && surveyId.length > 0){
                $.ajax({
                    url: '{!!  url("/survey/gallery") !!}/'+surveyId,
                    type: "GET",
                    dataType: 'json',
                    data: '',
                    success: function(data) {
                    console.log(data)
                        buildGallery(data.images);
                    },
                    error:function(data) {
                        alert('Disculpe. Ocurrió un error')
                    }
                });
            }
            function buildGallery(images){

                var url = '{{ url("uploads/")}}/';
                var html = '<div class="surveyGallery hide">';
                html += '<ul class="ace-thumbnails clearfix surveyImgs">';
                $.each(images, function( index, value ) {

                    html+='<li>' +
                     '      <div>' +
                     '          <img  value="'+value.id+'" width="150" height="150" alt="150x150" src="'+url+value.image+'" />' +
                     '          <div class="text">' +
                     '              <div class="inner">' +
                     '                  <span>'+value.name+'</span><br />' +
                     '                  <a class="survImg" href="'+url+value.image+'" data-rel="colorbox">' +
                     '                      <i class="ace-icon fa fa-search-plus"></i>' +
                     '                  </a>' +
                     '                  <a href="#" class="delete-img">' +
                     '                      <i class="ace-icon fa fa-times"></i>' +
                     '                  </a>' +
                     '              </div>' +
                     '          </div>' +
                     '      </div>' +
                     '  </li>';
                });
                html+= '</ul>';
                html+= '</div>';

                $('.page-content').append(html);
                $('.ace-thumbnails [data-rel="colorbox"]').colorbox(colorbox_params);
                $("#cboxLoadingGraphic").html("<i class='ace-icon fa fa-spinner orange fa-spin'></i>");//let's add a custom loading icon


                $(document).one('ajaxloadstart.page', function(e) {
                    $('#colorbox, #cboxOverlay').remove();
                });
            }
            //colorbox section
            var $overflow = '';
            var colorbox_params = {
                rel: 'colorbox',
                reposition:true,
                scalePhotos:true,
                scrolling:false,
                previous:'<i class="ace-icon fa fa-arrow-left"></i>',
                next:'<i class="ace-icon fa fa-arrow-right"></i>',
                close:'&times;',
                current:'{current} of {total}',
                maxWidth:'100%',
                maxHeight:'100%',
                onOpen:function(){
                    $overflow = document.body.style.overflow;
                    document.body.style.overflow = 'hidden';
                },
                onClosed:function(){
                    document.body.style.overflow = $overflow;
                },
                onComplete:function(){
                    $.colorbox.resize();
                }
            };

            // END GALLERY ===========================================

            var questions = $('input[name="respQuestions[]"]');
            var qContainer = $('.questions-list');

            if (questions.length > 0){
                $.each(questions, function( index, value ) {
                    var question = $.parseJSON($(value).val());
                    draw_question(question);
                });
                draw_cicle(questions.length + 1);
            }

            function draw_cicle(qnumber){
                var html = '<div class="row show-grid col-xs-12 col-sm-12 question" qtype="6">'
                html += '<h2 class="text-muted">';
                html += '<span class="number"> '+qnumber+' </span>';
                html += '<small>';
                html += '<i class="ace-icon fa fa-angle-double-right"></i>';
                html += '<span class="name"> Cicle </span>';
                html += '</small>';
                html += '</h2><select class="form-control">';
                    for(i=1;i<15;i++)
                        html += '<option class="options" value="'+i+'">'+i+'</option>';
                html += '</select>';
                html += '</div>';
                $(qContainer).append(html);
            }

            function draw_checkboxes(options){
                var html = '';
                $.each(options, function( index, value ) {
                    html += '<div class="checkbox"><label>' +
                    '    <input class="options" name="options" value='+index+' type="checkbox" class="ace">' +
                    '    <span class="lbl">'+value+'</span>' +
                    '</label></div>';
                });
                return html;
            }

            function draw_radiobuttons(options){
                var html = '';
                $.each(options, function( index, value ) {
                    html += '<div class="radio"><label>' +
                    '    <input class="options" name="options" value='+index+' type="radio" class="ace">' +
                    '    <span class="lbl">'+value+'</span>' +
                    '</label></div>';
                });
                return html;
            }

            function draw_list(options){

                var htmlOptions = '';
                $.each(options, function( index, value ) {
                    htmlOptions += '    <option class="options" value='+index+' >'+value+'</option>';
                });
                var html = '<select class="form-control">'+htmlOptions+'</select>';
                return html;
            }

            function draw_question(question){
                var qNumber = $('.question').length + 1;
                var questionName = question.name;
                var qType = question.type;
                var qId = question.id;

                if (questionName.length > 0 && qType.length > 0){
                    var answerElement = '';
                    var opciones = question.options;
                    if (typeof question.options == "object" ){
                        switch (qType) {
                            case '1':
                                answerElement = '<input class="col-xs-12 col-sm-12 options" name="answer" type="text" value=""/>';
                                break;
                            case '2':
                                if (typeof opciones == "object"){
                                    answerElement = draw_checkboxes(opciones);
                                }
                                break;
                            case '3':
                                if (typeof opciones == "object"){
                                    answerElement = draw_radiobuttons(opciones);
                                }
                                break;
                            case '4':
                                if (typeof opciones == "object"){
                                    answerElement = draw_list(opciones);
                                }
                                break;
                            case '5':
                                answerElement = '<div class="input-group col-xs-12 col-sm-5">' +
                                '                  <input class="form-control date-picker options" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd" />' +
                                '                     <span class="input-group-addon">' +
                                '                       <i class="fa fa-calendar bigger-110"></i>' +
                                '                      </span>' +
                                '               </div>';
                                break;
                            default:
                                answerElement = '<input class="col-xs-12 col-sm-12 options" name="answer" type="text" value=""/>';
                                break;
                        }

                        var html = '<div class="row show-grid col-xs-12 col-sm-12 question" qid='+qId+' qtype='+qType+' qname="'+questionName+'">' +
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
                }
            }

            $( ".answer-view-form" ).submit(function( event )
            {
                event.preventDefault();
                //get form div
                $form = $(".answer-view-form");
                $questions = $form.find('.questions-list .question')
                var question_count = $questions.length;
                var survey_id = $form.find("input[name='survey_id']").val();

                var answer = {};
                var question_list = [];
                var draft = false;
                $questions.each(function( index ) {
                    var question_id = $(this).attr('qid');
                    var question_type = $(this).attr('qtype');
                    var value = '';
                    if(question_type == 2)
                    {
                        value = $(this).find('input[type=checkbox]:checked').map(function(_, el) {
                                        return $(el).val();
                                    }).get();
                    }
                    else if(question_type == 4 || question_type == 6)
                    {
                        if(question_type == 6)
                            question_id = null;

                        value = $(this).find('.options:selected').val();
                    }
                    else
                    {
                        value = $(this).find('.options').val();
                    }
                    if(value == '' || value == null || value.length == 0){
                        draft = true;
                        value = null;
                    }
                    answer = { question_id: question_id, question_type: question_type, value: value };
                    question_list.push(answer)
                });

                if(draft == true){
                    if (confirm('La encuesta está incompleta. Si desea continuar se guardará un draft de la misma.')) {
                        var survey_obj = { survey_id: survey_id, question_count: question_count, answers:question_list, status:'Draft' };
                    }else{
                        return false;
                    }
                }else{
                    var survey_obj = { survey_id: survey_id, question_count: question_count, answers:question_list, status:'Completada' };
                }

                console.log(survey_obj);
                $.ajax({
                    type: 'POST',
                    url: '{{ URL::to('/') }}/survey/answer', //resource
                    data: {
                        _token: '{{ csrf_token() }}',
                        data: survey_obj
                    },
                    success: function(data) {
                    console.log(data)
                        if (data) window.location = '{{ URL::to('/') }}/dashboard/mysurveys';
                    },
                    error:function(data) {
                        alert('Disculpe. Ocurrió un error')
                    }
                });

            });

            $(document).on('focus',".date-picker", function(){
                $(this).datepicker({
                    autoclose: true,
                    todayHighlight: true
                });
            });
        });
    </script>
@endsection