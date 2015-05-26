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
            Mis Encuestas
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

                <div class="space-4"></div>
                <div class="dataTables_wrapper">
                    <table id="simple-table" class="table table-striped table-bordered table-hover dataTable">
                        <thead>
                        <tr>
                            <th>Encuesta</th>
                            <th>Status</th>
                            <th class="hidden-sm hidden-xs">Fecha</th>
                            <th class="hidden-xs">Cicle</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($surveys as $survey): ?>
                        <tr>
                            <td><?php echo $survey->name; ?></td>
                            <td>
                                <?php echo $survey->status; ?>
                            </td>
                            <td class="hidden-xs"><?php echo $survey->created_at; ?></td>
                            <td class="hidden-xs">
                                <?php echo (empty($survey->cicle) ? '-' : $survey->cicle ); ?>
                            </td>
                            <td>
                                <div class="hidden-sm hidden-xs btn-group">
                                    <a href="{{ URL::to('/survey/answer/edit/'.$survey->survey_user_id) }}" class="blue" title="Editar">
                                        <i class="ace-icon glyphicon glyphicon-edit"></i>
                                    </a>
                                    <a href="javascript:deleteSurveyAnswer('{{ $survey->survey_user_id }}');" class="red" title="Eliminar">
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
                                                <a href="{{ URL::to('/survey/answer/edit/'.$survey->survey_user_id) }}" class="tooltip-info" data-rel="tooltip" title="Editar">
                                                <span class="blue">
                                                    <i class="ace-icon glyphicon glyphicon-edit"></i>
                                                </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:deleteSurveyAnswer('{{ $survey->survey_user_id }}');" class="tooltip-success" data-rel="tooltip" title="Eliminar">
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
                                Mostrando <?php echo $surveys->firstItem(); ?> a <?php echo $surveys->lastItem(); ?> de un total de <?php echo $surveys->total(); ?>
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
                        if (data.deleted > 0) window.location = '{{ URL::to('/') }}/dashboard/mysurveys';
                    },
                    error:function(data) {
                        alert('Disculpe. Ocurrió un error')
                    }
                });
            }
        }

    </script>
@endsection