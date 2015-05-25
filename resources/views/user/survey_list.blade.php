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
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($surveys as $survey): ?>
                        <tr>
                            <td><?php echo $survey->name; ?></td>
                            <td><?php echo $survey->created_at; ?></td>
                            <td>
                                <div class="hidden-sm hidden-xs btn-group">
                                    <a href="{{ URL::to('/survey/answer/'.$survey->id) }}" class="green" title="Contestar">
                                        <i class="ace-icon glyphicon glyphicon-play"></i>
                                    </a>
                                </div>

                                <div class="hidden-md hidden-lg">
                                    <div class="inline pos-rel">
                                        <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                            <i class="ace-icon fa fa-cog icon-only bigger-110"></i>
                                        </button>

                                        <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                            <li>
                                                <a href="{{ URL::to('/survey/answer/'.$survey->id) }}" class="tooltip-info" data-rel="tooltip" title="Contestar">
                                                <span class="green">
                                                    <i class="ace-icon glyphicon glyphicon-play"></i>
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

        });
    </script>
@endsection