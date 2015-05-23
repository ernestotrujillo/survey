@extends('layout.app')

@section('title', 'Reportes de encuestas')

@section('breadcrumb')
    <li>
        Reportes
    </li>
@endsection

@section('content')

    <div class="page-header">
        <h1>
            Reportes de encuestas
            <a href="{{ url('/survey/create') }}" class="btn btn-sm btn-light">
                <i class="ace-icon glyphicon glyphicon-plus"></i> Agregar encuesta
            </a>
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

                <form id="filter" role="form" method="POST" action="{{ url('/user/filter') }}">
                    <div class="filter-users row">
                        <div class="col-xs-12">
                            <div class="wrapper">
                                <div class="filter-select filter-unit-wrap col-sm-2 col-xs-12">
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
                        <th class="center">
                            <label class="pos-rel">
                                <input type="checkbox" class="ace">
                                <span class="lbl"></span>
                            </label>
                        </th>
                        <th>Unumber</th>
                        <th>Nombre</th>
                        <th class="hidden-xs">Unit</th>
                        <th class="hidden-xs">Area</th>
                        <th>Encuesta</th>
                        <th class="hidden-xs">Fecha</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="center">
                            <label class="pos-rel">
                                <input type="checkbox" class="ace">
                                <span class="lbl"></span>
                            </label>
                        </td>

                        <td><?php echo $user->unumber; ?></td>
                        <td><?php echo $user->firstname .' '. $user->lastname; ?></td>
                        <td class="hidden-xs"><?php echo $user->unit_name; ?></td>
                        <td class="hidden-xs"><?php echo $user->area_name; ?></td>
                        <td><?php echo $user->survey_name; ?></td>
                        <td class="hidden-xs"><?php echo $user->created_at; ?></td>

                        <td>
                            <div class="hidden-sm hidden-xs btn-group">
                                <a href="{{ URL::to('/user/edit/'.$user->survey_id) }}" class="blue" title="Ver">
                                    <i class="ace-icon glyphicon glyphicon-eye-open"></i>
                                </a>

                                <a href="javascript:deleteUser('{{ $user->survey_id }}');" class="red" title="Eliminar">
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
                                            <a href="{{ URL::to('/user/edit/'.$user->survey_id) }}" class="tooltip-info" data-rel="tooltip" title="Ver">
                                                <span class="blue">
                                                    <i class="ace-icon glyphicon glyphicon-eye-open"></i>
                                                </span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="javascript:deleteUser('{{ $user->survey_id }}');" class="tooltip-success" data-rel="tooltip" title="Eliminar">
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

                if((unit > 0) || unit == 'all'){
                    if(unit != 'all'){
                        var area = $('.areas-select').val();
                        if(area > 0){
                            window.location = '{{ URL::to('/') }}/survey/report/unit/' + unit + '/area/' + area;
                        }else{
                            window.location = '{{ URL::to('/') }}/survey/report/unit/' + unit;
                        }
                    }else{
                        window.location = '{{ URL::to('/') }}/survey/report';
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

            if($('.units-select').val() > 0){
                if($('.areas-select').length){
                    $('.filter-area-wrap').removeClass('hidden');
                }else{
                    $('.units-select').trigger('change');
                }
            }

        });

        function deleteUser(id) {
            if (confirm('¿Esta seguro de eliminar el usuario?')) {
                $.ajax({
                    /*type: 'POST',
                    url: '{{ URL::to('/') }}/user/' + id, //resource
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.deleted > 0) window.location = 'user';
                    },
                    error:function(data) {
                        alert('Disculpe. Ocurrió un error')
                    }*/
                });
            }
        }
    </script>
@endsection