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
                                <?php echo Form::select('role', array('' => '-- Tipo de cuenta --', '5' => 'Todos') +$roles, '',array('class' => 'account-type-select col-xs-12')); ?>
                            </div>
                        </div>
                        <div class="wrapper">
                            <div class="filter-select filter-unit-wrap col-sm-2 col-xs-12 hidden">
                                <?php echo Form::select('unit', array('' => '-- Unidad --', '5' => 'Todas') +$units, '',array('class' => 'units-select col-xs-12')); ?>
                            </div>
                        </div>
                        <div class="wrapper">
                            <div class="filter-select filter-area-wrap col-sm-2 col-xs-12 hidden"></div>
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
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Unumber</th>
                        <th class="hidden-xs">Email</th>
                        <th class="hidden-xs">Cuenta</th>
                        <th class="hidden-xs">Estado</th>
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

                        <td><?php echo $user->firstname; ?></td>
                        <td><?php echo $user->lastname; ?></td>
                        <td><?php echo $user->unumber; ?></td>
                        <td class="hidden-xs"><?php echo $user->email; ?></td>
                        <td class="hidden-xs">
                            <?php if($user->roles[0]->id == 1) echo 'Usuario'; ?>
                            <?php if($user->roles[0]->id == 2) echo 'Manager'; ?>
                            <?php if($user->roles[0]->id == 3) echo 'Director'; ?>
                            <?php if($user->roles[0]->id == 4) echo 'Administrador'; ?>
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
                                <a href="#" class="blue" title="Editar">
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
                                            <a href="#" class="tooltip-info" data-rel="tooltip" title="Editar">
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
                if(account_type > 0 && account_type <= 4){
                    window.location = '{{ URL::to('/') }}/user/role/' + account_type;
                }else if(account_type == 5) {
                    window.location = '{{ URL::to('/') }}/user';
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

            $('.units-select').on('change', function() {
                var unit = $(this).val();
                var account_type = $('.account-type-select').val();
                if(unit > 0 && unit < 4 && (account_type == 1 || account_type == 2)){

                    $.ajax({
                        method: "GET",
                        url: "{{ URL::to('/') }}/area/filter/unit/"+unit,
                        success: function(areas) {
                            var html = '<select class="areas-select col-xs-12" name="area">';
                            html += '<option value="" selected="selected">-- Seleccione --</option>';
                            html += '<option value="" selected="5">Todas</option>';
                            $.each(areas, function( index, value ) {
                                html += '<option value="'+index+'">'+value+'</option>';
                            });
                            html += '</select>';
                            $('.filter-area-wrap').html(html)
                            $('.filter-area-wrap').removeClass('hidden');
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
