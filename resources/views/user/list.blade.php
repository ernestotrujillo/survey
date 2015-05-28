@extends('layout.app')

@section('title', 'Lista usuarios')

@section('breadcrumb')
    <li>
        Usuarios
    </li>
@endsection

@section('content')

    <div class="page-header">
        <h1>
            Usuarios
            <a href="{{ url('/user/create') }}" class="btn btn-sm btn-light">
                <i class="ace-icon glyphicon glyphicon-plus"></i> Agregar nuevo
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
                            <div class="filter-select filter-role-wrap col-sm-2 col-xs-12">
                                <?php if(!isset($role)) $role = ''; ?>
                                <?php echo Form::select('role', array('' => '-- Tipo de cuenta --', 'all' => 'Todos') +$roles, $role, array('class' => 'account-type-select col-xs-12')); ?>
                            </div>
                        </div>
                        <div class="wrapper">
                            <div class="filter-select filter-unit-wrap col-sm-2 col-xs-12 hidden">
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
                        <th># Empleado</th>
                        <th>Nombre</th>
                        <th>Unidad</th>
                        <th>Distrito</th>
                        <th>Reporta a</th>
                        <th class="hidden-xs">Cuenta</th>
                        <th class="hidden-xs">Estado</th>
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
                        <td><?php echo $user->lastname; ?>, <?php echo $user->firstname; ?></td>
                        <td>
                            <?php
                                if(isset($user->area_unit_id)){
                                    echo $units[$user->area_unit_id];
                                }else{
                                    echo (isset($units[$user->unit_id]) ? $units[$user->unit_id] : '-');
                                }
                            ?>
                        </td>
                        <td><?php echo (isset($user->area_name) ? $user->area_name : '-'); ?></td>
                        <td>
                            <?php
                                if($user->role_id == 1){
                                    echo (isset($manager[$user->area_id]) ? $manager[$user->area_id] : '-');
                                }elseif($user->role_id == 2){
                                    echo (isset($director[$user->area_unit_id]) ? $director[$user->area_unit_id] : '-');
                                }else{
                                    echo '-';
                                }
                            ?>
                        </td>
                        <td class="hidden-xs">
                            <?php if(isset($user->role->name)){ echo $user->role->name; ?>
                            <?php }elseif(isset($user->role_name)){ echo $user->role_name; } ?>
                        </td>
                        <td class="hidden-xs">
                            <?php if($user->active){ ?>
                                    <span class="label label-success label-white middle">Activo</span>
                            <?php }else{ ?>
                                <span class="label label-danger label-white middle">Bloqueado</span>
                            <?php } ?>
                        </td>

                        <td>
                            <div class="hidden-sm hidden-xs btn-group">
                                <a href="{{ URL::to('/user/edit/'.$user->id) }}" class="blue" title="Editar">
                                    <i class="ace-icon glyphicon glyphicon-edit"></i>
                                </a>

                                <a href="javascript:deleteUser('{{ $user->id }}');" class="red" title="Eliminar">
                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                </a>

                                <?php if($user->active == 1){ ?>
                                    <a href="javascript:banUser('{{ $user->id }}');" class="red" title="Bloquear">
                                        <i class="ace-icon fa fa-ban"></i>
                                    </a>
                                <?php }else{ ?>
                                    <a href="javascript:activeUser('{{ $user->id }}');" class="green" title="Activar">
                                        <i class="ace-icon glyphicon glyphicon-ok"></i>
                                    </a>
                                <?php } ?>
                            </div>

                            <div class="hidden-md hidden-lg">
                                <div class="inline pos-rel">
                                    <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                        <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                        <li>
                                            <a href="{{ URL::to('/user/edit/'.$user->id) }}" class="tooltip-info" data-rel="tooltip" title="Editar">
                                                <span class="blue">
                                                    <i class="ace-icon glyphicon glyphicon-edit"></i>
                                                </span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="javascript:deleteUser('{{ $user->id }}');" class="tooltip-success" data-rel="tooltip" title="Eliminar">
                                                <span class="red">
                                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                </span>
                                            </a>
                                        </li>

                                        <?php if($user->active == 1){ ?>
                                            <li>
                                                <a href="javascript:banUser('{{ $user->id }}');" class="tooltip-error" data-rel="tooltip" title="Bloquear">
                                                    <span class="red">
                                                        <i class="ace-icon fa fa-ban"></i>
                                                    </span>
                                                </a>
                                            </li>
                                        <?php }else{ ?>
                                            <li>
                                                <a href="javascript:activeUser('{{ $user->id }}');" class="tooltip-error" data-rel="tooltip" title="Activar">
                                                    <span class="green">
                                                        <i class="ace-icon glyphicon glyphicon-ok"></i>
                                                    </span>
                                                </a>
                                            </li>
                                        <?php } ?>
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
            <!-- PAGE CONTENT ENDS -->

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
                var account_type = $('.account-type-select').val();
                var unit = $('.units-select').val();

                if((account_type > 0) || account_type == 'all'){
                    if(account_type > 0 && account_type <= 3){
                        if(unit > 0 || unit == 'all'){
                            var area = $('.areas-select').val();
                            if(area > 0 || area == 'all'){
                                window.location = '{{ URL::to('/') }}/user/role/' + account_type + '/unit/' + unit + '/area/' + area;
                            }else{
                                window.location = '{{ URL::to('/') }}/user/role/' + account_type + '/unit/' + unit;
                            }
                        }else{
                            window.location = '{{ URL::to('/') }}/user/role/' + account_type;
                        }
                    }else{
                        window.location = '{{ URL::to('/') }}/user/role/' + account_type;
                    }
                }else{
                    alert('Seleccione un tipo de cuenta.')
                }

                event.preventDefault();
            });

            $('.account-type-select').on('change', function() {
                var account_type = $(this).val();
                if(account_type == 1 || account_type == 2) {
                    $('.units-select').val('').trigger('change');
                    $('.filter-unit-wrap').removeClass('hidden');
                }else if(account_type == 3){
                    $('.units-select').val('').trigger('change');
                    $('.filter-unit-wrap').removeClass('hidden');
                }else{
                    $('.units-select').val('').trigger('change');
                    $('.filter-unit-wrap').addClass('hidden');
                }
            });

            var area = '<?php if(isset($area)) echo $area; ?>';
            $('.units-select').on('change', function() {
                var unit = $(this).val();
                var account_type = $('.account-type-select').val();
                if(unit > 0 && (account_type == 1 || account_type == 2)){

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

            if($('.account-type-select').val() > 0 && $('.account-type-select').val() < 4){
                $('.filter-unit-wrap').removeClass('hidden')
            }

            if($('.units-select').val() > 0 && ($('.account-type-select').val() == 1 || $('.account-type-select').val() == 2)){
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
                    type: 'POST',
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
                    }
                });
            }
        }

        function banUser(id) {
            if (confirm('¿Esta seguro de bloquear al usuario?')) {
                $.ajax({
                    type: 'GET',
                    url: '{{ URL::to('/') }}/user/ban/' + id, //resource
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data) window.location = 'user';
                    },
                    error:function(data) {
                        alert('Disculpe. Ocurrió un error')
                    }
                });
            }
        }

        function activeUser(id) {
            if (confirm('¿Esta seguro de activar el usuario?')) {
                $.ajax({
                    type: 'GET',
                    url: '{{ URL::to('/') }}/user/active/' + id, //resource
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data) window.location = 'user';
                    },
                    error:function(data) {
                        alert('Disculpe. Ocurrió un error')
                    }
                });
            }
        }
    </script>
@endsection
