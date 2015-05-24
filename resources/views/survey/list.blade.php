@extends('layout.app')

@section('title', 'Lista de encuestas')

@section('breadcrumb')
    <li>
        Encuestas
    </li>
@endsection

@section('content')

    <div class="page-header">
        <h1>
            Encuestas
            <a href="{{ url('/survey/create') }}" class="btn btn-sm btn-light">
                <i class="ace-icon glyphicon glyphicon-plus"></i> Agregar nueva
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
                        <th>Unidad</th>
                        <th class="hidden-xs">Estado</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($surveys as $survey): ?>
                    <tr>
                        <td class="center">
                            <label class="pos-rel">
                                <input type="checkbox" class="ace">
                                <span class="lbl"></span>
                            </label>
                        </td>

                        <td>{!! $survey->name !!}</td>
                        <td>{!! $survey->unit !!}</td>
                        <td class="hidden-xs">
                            <?php if($survey->active){ ?>
                                    <span class="label label-success label-white middle">Activo</span>
                            <?php }else{ ?>
                                <span class="label label-danger label-white middle">Bloqueado</span>
                            <?php } ?>
                        </td>

                        <td>
                            <div class="hidden-sm hidden-xs btn-group">
                                <a href="javascript:editSurvey('{{ $survey->id }}');" class="blue" title="Editar">
                                    <i class="ace-icon glyphicon glyphicon-edit"></i>
                                </a>

                                <a href="javascript:deleteSurvey('{{ $survey->id }}');" class="red" title="Eliminar">
                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="dataTables_info">
                            Mostrando {!! $surveys->firstItem() !!} a {!!  $surveys->lastItem() !!} de un total de {!! $surveys->total() !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="dataTables_paginate">
                            <?php echo $surveys->render(); ?>
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
                event.preventDefault();
                var unit = $('.units-select').val();

                if(unit > 0){
                    window.location = '{{ URL::to('/') }}/survey/unit/' + unit;
                }else{
                    window.location = '{{ URL::to('/') }}/survey';
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

    </script>
@endsection
