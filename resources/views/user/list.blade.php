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

                                <a href="#" class="red" title="Bloquear">
                                    <i class="ace-icon fa fa-ban"></i>
                                </a>
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

                                        <li>
                                            <a href="#" class="tooltip-error" data-rel="tooltip" title="Bloquear">
                                                <span class="red">
                                                    <i class="ace-icon fa fa-ban"></i>
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

        function deleteUser(id) {
            if (confirm('Eliminar usuario?')) {
                $.ajax({
                    type: 'POST',
                    data: {_method: 'delete'},
                    url: 'users/' + id, //resource
                    success: function(affectedRows) {
                        //if something was deleted, we redirect the user to the users page, and automatically the user that he deleted will disappear
                        if (affectedRows > 0) window.location = 'user';
                    }
                });
            }
        }
    </script>
@endsection
