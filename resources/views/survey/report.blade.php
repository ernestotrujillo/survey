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

                <?php print_r($surveys); ?>

        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('script')
    <script type="text/javascript">
        jQuery(function($) {

        });
    </script>
@endsection