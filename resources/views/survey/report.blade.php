@extends('layout.app')

@section('title', 'Reportes de encuestas')

@section('breadcrumb')
    <li>
        Reportes
    </li>
@endsection

@section('content')
    <?php $user_session = session('user'); ?>
    <div class="page-header">
        <h1>
            Reportes de encuestas
            <?php if($user_session['role'] == 4){ ?>
                <a href="{{ url('/survey/create') }}" class="btn btn-sm btn-light">
                    <i class="ace-icon glyphicon glyphicon-plus"></i> Agregar encuesta
                </a>
            <?php } ?>
        </h1>

    </div>

    <div class="row">
        <div class="col-xs-12">

            <!-- PAGE CONTENT BEGINS -->
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    Disculpe! Exíste un problema.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- view handling messages -->
            @include('errors.error')

                <form id="filter" role="form" method="POST" action="{{ url('/survey/report') }}">
                    <div class="filter-users row">
                        <div class="col-xs-12">
                            <div class="wrapper">
                                <div class="filter-select filter-unit-wrap col-sm-2 col-xs-12 <?php if($user_session['role'] != 4) echo 'hidden'; ?>">
                                    <?php if(!isset($unit)) $unit = ''; ?>
                                    <?php echo Form::select('unit', array('' => '-- Unidad --', 'all' => 'Todas') +$units, $unit, array('class' => 'units-select col-xs-12')); ?>
                                </div>
                            </div>
                            <div class="wrapper">
                                <div class="filter-select filter-area-wrap col-sm-2 col-xs-12 hidden">
                                    <?php if(!isset($area)) $area = ''; ?>
                                    <?php if(isset($areas) && $areas != null){ ?>
                                    <?php echo Form::select('area', array('' => '-- Area --', 'all' => 'Todas') +$areas, $area, array('class' => 'areas-select col-xs-12')); ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="wrapper">
                                <div class="filter-buttom col-sm-1 col-xs-12">
                                    <button type="submit" class="btn btn-white btn-inverse btn-sm">Filtrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            <div class="space-4"></div>
            <div class="dataTables_wrapper">
                <table id="simple-table" class="table table-striped table-bordered table-hover dataTable">
                    <thead>
                    <tr>
                        <!--th class="center">
                            <label class="pos-rel">
                                <input type="checkbox" class="ace">
                                <span class="lbl"></span>
                            </label>
                        </th-->
                        <th>Nro. Empleado</th>
                        <th>Nombre</th>
                        <th class="hidden-xs">Unidad</th>
                        <th class="hidden-xs">Area</th>
                        <th>Encuesta</th>
                        <th>Manager</th>
                        <th>Director</th>
                        <th class="hidden-xs">Ciclo</th>
                        <th class="hidden-xs">Fecha</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <!--td class="center">
                            <label class="pos-rel">
                                <input type="checkbox" class="ace">
                                <span class="lbl"></span>
                            </label>
                        </td-->

                        <td><?php echo $user->unumber; ?></td>
                        <td><?php echo $user->lastname .', '. $user->firstname; ?></td>
                        <td class="hidden-xs"><?php echo $user->unit_name; ?></td>
                        <td class="hidden-xs"><?php echo $user->area_name; ?></td>
                        <td><?php echo $user->survey_name; ?></td>
                        <td><?php echo (isset($manager[$user->area_id]) ? $manager[$user->area_id] : '-'); ?></td>
                        <td><?php echo (isset($director[$user->unit_id]) ? $director[$user->unit_id] : '-'); ?></td>
                        <td class="hidden-xs"><?php echo $user->cicle; ?></td>
                        <td class="hidden-xs"><?php echo $user->created_at; ?></td>

                        <td>
                            <div class="hidden-sm hidden-xs btn-group">
                                <a href="javascript:void(0);" data-id="{{ $user->survey_user_id }}" class="view-answers blue" title="Ver">
                                    <i class="ace-icon glyphicon glyphicon-eye-open"></i>
                                </a>

                                <a href="javascript:deleteSurveyAnswer('{{ $user->survey_user_id }}');" class="red" title="Eliminar">
                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                </a>
                            </div>

                            <div class="hidden-md hidden-lg">
                                <div class="inline pos-rel">
                                    <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                        <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                        <li>
                                            <a href="javascript:void(0);" data-id="{{ $user->survey_user_id }}" class="tooltip-info view-answers" data-rel="tooltip" title="Ver">
                                                <span class="blue">
                                                    <i class="ace-icon glyphicon glyphicon-eye-open"></i>
                                                </span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="javascript:deleteSurveyAnswer('{{ $user->survey_user_id }}');" class="tooltip-success" data-rel="tooltip" title="Eliminar">
                                                <span class="red">
                                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="dataTables_info">
                            Mostrando <?php echo $users->firstItem(); ?> a <?php echo $users->lastItem(); ?> de un total de <?php echo $users->total(); ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="dataTables_paginate">
                            <?php echo $users->render(); ?>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.col -->
    </div><!-- /.row -->

    <!-- MODALES -->
    <div id="modal-answers" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="smaller lighter blue no-margin">Respuestas</h3>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="answers-survey col-md-10 col-md-offset-1"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-sm btn-danger pull-right" data-dismiss="modal">
                        <i class="ace-icon fa fa-times"></i>
                        Cerrar
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        jQuery(function($) {
            //And for the first simple table, which doesn't have TableTools or dataTables
            //select/deselect all rows according to table header checkbox
            var active_class = 'active';
            $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
                var th_checked = this.checked;//checkbox inside "TH" table header

                $(this).closest('table').find('tbody > tr').each(function(){
                    var row = this;
                    if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
                    else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
                });
            });

            //select/deselect a row when the checkbox is checked/unchecked
            $('#simple-table').on('click', 'td input[type=checkbox]' , function(){
                var $row = $(this).closest('tr');
                if(this.checked) $row.addClass(active_class);
                else $row.removeClass(active_class);
            });

            //filters
            $( "#filter" ).submit(function( event )
            {
                var unit = $('.units-select').val();
                var url = '<?php if($user_session['role'] == 3) echo 'director/'; ?>';

                if((unit > 0) || unit == 'all'){
                    if(unit != 'all'){
                        var area = $('.areas-select').val();
                        if(area > 0){
                            window.location = '{{ URL::to('/') }}/'+ url +'survey/report/unit/' + unit + '/area/' + area;
                        }else{
                            window.location = '{{ URL::to('/') }}/'+ url +'survey/report/unit/' + unit;
                        }
                    }else{
                        window.location = '{{ URL::to('/') }}/'+ url +'survey/report';
                    }
                }else{
                    alert('Por favor! seleccione un unit.')
                }

                event.preventDefault();
            });

            var area = '<?php if(isset($area)) echo $area; ?>';
            $('.units-select').on('change', function() {
                var unit = $(this).val();
                if(unit > 0){

                    $.ajax({
                        method: "GET",
                        url: "{{ URL::to('/') }}/area/filter/unit/"+unit,
                        success: function(areas) {
                            var html = '<select class="areas-select col-xs-12" name="area">';
                            html += '<option value="" selected="selected">-- Seleccione --</option>';
                            if(area == 'all') {
                                html += '<option value="all" selected="selected">Todas</option>';
                            }else{
                                html += '<option value="all">Todas</option>';
                            }
                            $.each(areas, function( index, value ) {
                                if(area == index){
                                    html += '<option value="'+index+'" selected="selected">'+value+'</option>';
                                }else{
                                    html += '<option value="'+index+'">'+value+'</option>';
                                }
                            });
                            html += '</select>';
                            $('.filter-area-wrap').html(html)
                            $('.filter-area-wrap').removeClass('hidden');
                            area = '';
                        },
                        error: function(data) {
                            alert('Disculpe. Hay un error para obtener las areas de esta unidad.')
                        }
                    });

                }else{
                    $('.areas-select').val('');
                    $('.filter-area-wrap').addClass('hidden');
                }
            });

            <?php if($user_session['role'] != 2) { ?>
                if($('.units-select').val() > 0){
                    if($('.areas-select').length){
                        $('.filter-area-wrap').removeClass('hidden');
                    }else{
                        $('.units-select').trigger('change');
                    }
                }
            <?php }else{ ?>
                $('.filter-buttom').addClass('hidden');
            <?php } ?>


            //select/deselect a row when the checkbox is checked/unchecked
            $('#simple-table').on('click', '.view-answers' , function(event){
                event.preventDefault();
                var id = $(this).attr('data-id');
                var user_id = $(this).attr('data-user-id');
                $.ajax({
                    type: 'GET',
                    url: '{{ URL::to('/') }}/survey/ajax/' + id, //resource
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.success)
                        {
                            modalSurvey(data.questions, data.survey, data.survey_user)
                            $('#modal-answers').modal('show')
                        }else
                        {
                            alert('Disculpe. Ocurrió un error')
                        }
                    },
                    error:function(data) {
                        alert('Disculpe. Ocurrió un error')
                    }
                });
            });

        });

        function deleteSurveyAnswer(id) {
            if (confirm('¿Esta seguro de eliminar la encuesta?')) {
                $.ajax({
                    type: 'POST',
                    url: '{{ URL::to('/') }}/survey/user/delete/' + id, //resource
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.deleted > 0)
                        {
                            <?php if($user_session['role'] == 4){ ?>
                                window.location = '{{ URL::to('/') }}/survey/report';
                            <?php } ?>
                            <?php if($user_session['role'] == 3){ ?>
                                window.location = '{{ URL::to('/') }}/director/survey/report';
                            <?php } ?>
                            <?php if($user_session['role'] == 2){ ?>
                                window.location = '{{ URL::to('/') }}/manager/survey/report';
                            <?php } ?>
                        }
                    },
                    error:function(data) {
                        alert('Disculpe. Ocurrió un error')
                    }
                });
            }
        }

        var qContainer = $('.modal-body .answers-survey');
        function modalSurvey(questions, survey, survey_user){
            //** VER ENCUESTA EN MODAL ++//
            qContainer.html('');
            if (questions.length > 0){
                $.each(questions, function( index, value ) {
                    var question = value;
                    draw_question(question);
                });
                var cicle = survey_user.cicle;
                draw_cicle(questions.length + 1, cicle);
            }
        }

        function draw_cicle(qnumber, cicle){
            var html = '<div class="row show-grid col-xs-12 col-sm-12 question" qtype="6">'
            html += '<h2 class="text-muted">';
            html += '<span class="number"> '+qnumber+' </span>';
            html += '<small>';
            html += '<i class="ace-icon fa fa-angle-double-right"></i>';
            html += '<span class="name"> Ciclo </span>';
            html += '</small>';
            html += '</h2>';
            for(i=1;i<11;i++){
                if(cicle != null && cicle == i){
                    html += '<h4>'+i+'</h4>';
                }
            }
            html += '</div>';
            $(qContainer).append(html);
        }

        function draw_checkboxes(options, answer){
            var html = '';
            $.each(options, function( index, value ) {
                if(answer.value.indexOf(index) >= 0){
                    html += '<h4>'+value+'</h4>';
                }
            });
            return html;
        }

        function draw_radiobuttons(options, answer){
            var html = '';
            $.each(options, function( index, value ) {
                if(answer.value == index){
                    html += '<h4>'+value+'</h4>';
                }
            });
            return html;
        }

        function draw_list(options, answer){

            var html = '';
            $.each(options, function( index, value ) {
                if(answer.value == index){
                    html += '<h4>'+value+'<h4>';
                }
            });
            return html;
        }

        function draw_question(question){
            var qNumber = $('.question').length + 1;
            var questionName = question.name;
            var qType = question.type;
            var qId = question.id;
            var answer = question.answer;

            if (questionName.length > 0 && qType.length > 0){
                var answerElement = '';
                var opciones = question.options;
                if (typeof question.options == "object" ){
                    switch (qType) {
                        case '1':
                            if(answer.value == null) answer.value = '';
                            answerElement = '<h4>'+answer.value+'</h4>';
                            break;
                        case '2':
                            if (typeof opciones == "object"){
                                if(answer.value == null) { answer.value = []; }else{ answer.value = answer.value.split("-") };
                                answerElement = draw_checkboxes(opciones, answer);
                            }
                            break;
                        case '3':
                            if (typeof opciones == "object"){
                                if(answer.value == null) answer.value = '';
                                answerElement = draw_radiobuttons(opciones, answer);
                            }
                            break;
                        case '4':
                            if (typeof opciones == "object"){
                                if(answer.value == null) answer.value = '';
                                answerElement = draw_list(opciones, answer);
                            }
                            break;
                        case '5':
                            if(answer.value == null) answer.value = '';
                            answerElement = '<h4>'+answer.value+'</h4>';
                            break;
                        default:
                            answerElement = '<input class="col-xs-12 col-sm-12 options" name="answer" type="text" value=""/>';
                            break;
                    }

                    var html = '<div class="row show-grid col-xs-12 col-sm-12 question" qid='+qId+' qtype='+qType+' qanswer="'+answer.id+'" qname="'+questionName+'">' +
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

    </script>
@endsection