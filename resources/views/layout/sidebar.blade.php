<?php $user_session = session('user'); ?>

<div id="sidebar" class="sidebar responsive">
    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
    </script>

    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
            <button class="btn btn-success">
                <i class="ace-icon fa fa-signal"></i>
            </button>

            <button class="btn btn-info">
                <i class="ace-icon fa fa-pencil"></i>
            </button>

            <!-- #section:basics/sidebar.layout.shortcuts -->
            <button class="btn btn-warning">
                <i class="ace-icon fa fa-users"></i>
            </button>

            <button class="btn btn-danger">
                <i class="ace-icon fa fa-cogs"></i>
            </button>

            <!-- /section:basics/sidebar.layout.shortcuts -->
        </div>

        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>

            <span class="btn btn-info"></span>

            <span class="btn btn-warning"></span>

            <span class="btn btn-danger"></span>
        </div>
    </div><!-- /.sidebar-shortcuts -->

    <ul class="nav nav-list">
        <li class="">
            <a href="{{ url('/') }}">
                <i class="menu-icon fa fa-tachometer"></i>
                <span class="menu-text"> Dashboard </span>
            </a>

            <b class="arrow"></b>
        </li>

        <?php if($user_session['role'] == 2){ ?>
            <li class="">
                <a href="{{ url('/') }}">
                    <i class="menu-icon glyphicon glyphicon-stats"></i>
                    <span class="menu-text"> Reportes </span>
                </a>

                <b class="arrow"></b>
            </li>
        <?php } ?>

        <?php if($user_session['role'] == 3){ ?>
            <li class="">
                <a href="{{ url('/') }}">
                    <i class="menu-icon glyphicon glyphicon-stats"></i>
                    <span class="menu-text"> Reportes </span>
                </a>

                <b class="arrow"></b>
            </li>
        <?php } ?>

        <?php if($user_session['role'] == 4){ ?>
            <li class="">
                <a href="{{ url('/survey/report') }}">
                    <i class="menu-icon glyphicon glyphicon-stats"></i>
                    <span class="menu-text"> Reportes </span>
                </a>

                <b class="arrow"></b>
            </li>
            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-user"></i>
                    <span class="menu-text">
                        Cuentas
                    </span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">

                    <li class="">
                        <a href="{{ url('/user/create') }}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Crear Cuenta
                        </a>
                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="{{ url('/user') }}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Usuarios
                        </a>
                        <b class="arrow"></b>
                    </li>

                </ul>
            </li>
            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-question"></i>
                    <span class="menu-text">
                        Encuestas
                    </span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">

                    <li class="">
                        <a href="{{ url('/survey/create') }}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Crear Encuesta
                        </a>
                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="{{ url('/survey') }}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Encuestas
                        </a>
                        <b class="arrow"></b>
                    </li>

                </ul>
            </li>
        <?php } ?>

    </ul><!-- /.nav-list -->

    <!-- #section:basics/sidebar.layout.minimize -->
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>

    <!-- /section:basics/sidebar.layout.minimize -->
    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
    </script>
</div>