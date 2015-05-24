@extends('layout.app')

@section('title', 'Dashboard')

@section('content')

    <div class="page-header">
        <h1>
            Dashboard
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

                <div class="row">
                    <div class="col-sm-6">
                        <div class="widget-box transparent" id="recent-box">
                            <div class="widget-header">
                                <h4 class="widget-title lighter smaller">
                                    <i class="ace-icon fa fa-rss orange"></i>Últimas iteracciones
                                </h4>

                                <div class="widget-toolbar no-border">
                                    <ul class="nav nav-tabs" id="recent-tab">
                                        <li class="active">
                                            <a data-toggle="tab" href="#task-tab" aria-expanded="false">Encuestas realizadas</a>
                                        </li>

                                        <li class="">
                                            <a data-toggle="tab" href="#comment-tab" aria-expanded="false">Encuestas</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main padding-4">
                                    <div class="tab-content padding-8">
                                        <div id="task-tab" class="tab-pane active">

                                            <!-- #section:pages/dashboard.tasks -->
                                            <ul id="tasks" class="item-list ui-sortable">
                                                <li class="item-orange clearfix ui-sortable-handle">
                                                    <label class="inline">
                                                        <span class="lbl"> Answering customer questions</span>
                                                    </label>
                                                </li>

                                                <li class="item-red clearfix ui-sortable-handle">
                                                    <label class="inline">
                                                        <span class="lbl"> Fixing bugs</span>
                                                    </label>

                                                    <!-- #section:custom/extra.action-buttons -->
                                                    <div class="pull-right action-buttons">
                                                        <a href="#" class="blue">
                                                            <i class="ace-icon glyphicon glyphicon-eye-open"></i>
                                                        </a>
                                                    </div>

                                                    <!-- /section:custom/extra.action-buttons -->
                                                </li>

                                                <li class="item-default clearfix ui-sortable-handle">
                                                    <label class="inline">
                                                        <span class="lbl"> Adding new features</span>
                                                    </label>
                                                </li>

                                                <li class="item-blue clearfix ui-sortable-handle">
                                                    <label class="inline">
                                                        <span class="lbl"> Upgrading scripts used in template</span>
                                                    </label>
                                                </li>
                                            </ul>

                                            <!-- /section:pages/dashboard.tasks -->
                                        </div>

                                        <div id="comment-tab" class="tab-pane">
                                            <!-- #section:pages/dashboard.comments -->
                                            <div class="comments ace-scroll" style="position: relative;"><div class="scroll-track" style="display: none;"><div class="scroll-bar"></div></div><div class="scroll-content" style="max-height: 300px;">
                                                    <div class="itemdiv commentdiv">
                                                        <div class="user">
                                                            <img alt="Bob Doe's Avatar" src="../assets/avatars/avatar.png">
                                                        </div>

                                                        <div class="body">
                                                            <div class="name">
                                                                <a href="#">Bob Doe</a>
                                                            </div>

                                                            <div class="time">
                                                                <i class="ace-icon fa fa-clock-o"></i>
                                                                <span class="green">6 min</span>
                                                            </div>

                                                            <div class="text">
                                                                <i class="ace-icon fa fa-quote-left"></i>
                                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis …
                                                            </div>
                                                        </div>

                                                        <div class="tools">
                                                            <div class="inline position-relative">
                                                                <button class="btn btn-minier bigger btn-yellow dropdown-toggle" data-toggle="dropdown">
                                                                    <i class="ace-icon fa fa-angle-down icon-only bigger-120"></i>
                                                                </button>

                                                                <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                                    <li>
                                                                        <a href="#" class="tooltip-success" data-rel="tooltip" title="" data-original-title="Approve">
                                                                            <span class="green">
                                                                                <i class="ace-icon fa fa-check bigger-110"></i>
                                                                            </span>
                                                                        </a>
                                                                    </li>

                                                                    <li>
                                                                        <a href="#" class="tooltip-warning" data-rel="tooltip" title="" data-original-title="Reject">
                                                                            <span class="orange">
                                                                                <i class="ace-icon fa fa-times bigger-110"></i>
                                                                            </span>
                                                                        </a>
                                                                    </li>

                                                                    <li>
                                                                        <a href="#" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete">
                                                                            <span class="red">
                                                                                <i class="ace-icon fa fa-trash-o bigger-110"></i>
                                                                            </span>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="itemdiv commentdiv">
                                                        <div class="user">
                                                            <img alt="Jennifer's Avatar" src="../assets/avatars/avatar1.png">
                                                        </div>

                                                        <div class="body">
                                                            <div class="name">
                                                                <a href="#">Jennifer</a>
                                                            </div>

                                                            <div class="time">
                                                                <i class="ace-icon fa fa-clock-o"></i>
                                                                <span class="blue">15 min</span>
                                                            </div>

                                                            <div class="text">
                                                                <i class="ace-icon fa fa-quote-left"></i>
                                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis …
                                                            </div>
                                                        </div>

                                                        <div class="tools">
                                                            <div class="action-buttons bigger-125">
                                                                <a href="#">
                                                                    <i class="ace-icon fa fa-pencil blue"></i>
                                                                </a>

                                                                <a href="#">
                                                                    <i class="ace-icon fa fa-trash-o red"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="itemdiv commentdiv">
                                                        <div class="user">
                                                            <img alt="Joe's Avatar" src="../assets/avatars/avatar2.png">
                                                        </div>

                                                        <div class="body">
                                                            <div class="name">
                                                                <a href="#">Joe</a>
                                                            </div>

                                                            <div class="time">
                                                                <i class="ace-icon fa fa-clock-o"></i>
                                                                <span class="orange">22 min</span>
                                                            </div>

                                                            <div class="text">
                                                                <i class="ace-icon fa fa-quote-left"></i>
                                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis …
                                                            </div>
                                                        </div>

                                                        <div class="tools">
                                                            <div class="action-buttons bigger-125">
                                                                <a href="#">
                                                                    <i class="ace-icon fa fa-pencil blue"></i>
                                                                </a>

                                                                <a href="#">
                                                                    <i class="ace-icon fa fa-trash-o red"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="itemdiv commentdiv">
                                                        <div class="user">
                                                            <img alt="Rita's Avatar" src="../assets/avatars/avatar3.png">
                                                        </div>

                                                        <div class="body">
                                                            <div class="name">
                                                                <a href="#">Rita</a>
                                                            </div>

                                                            <div class="time">
                                                                <i class="ace-icon fa fa-clock-o"></i>
                                                                <span class="red">50 min</span>
                                                            </div>

                                                            <div class="text">
                                                                <i class="ace-icon fa fa-quote-left"></i>
                                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque commodo massa sed ipsum porttitor facilisis …
                                                            </div>
                                                        </div>

                                                        <div class="tools">
                                                            <div class="action-buttons bigger-125">
                                                                <a href="#">
                                                                    <i class="ace-icon fa fa-pencil blue"></i>
                                                                </a>

                                                                <a href="#">
                                                                    <i class="ace-icon fa fa-trash-o red"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div></div>

                                            <div class="hr hr8"></div>

                                            <div class="center">
                                                <i class="ace-icon fa fa-comments-o fa-2x green middle"></i>

                                                &nbsp;
                                                <a href="#" class="btn btn-sm btn-white btn-info">
                                                    See all comments &nbsp;
                                                    <i class="ace-icon fa fa-arrow-right"></i>
                                                </a>
                                            </div>

                                            <div class="hr hr-double hr8"></div>

                                            <!-- /section:pages/dashboard.comments -->
                                        </div>
                                    </div>
                                </div><!-- /.widget-main -->
                            </div><!-- /.widget-body -->
                        </div><!-- /.widget-box -->
                    </div><!-- /.col -->

                    <div class="col-sm-6">
                        <div class="widget-box">
                            <div class="widget-header">
                                <h4 class="widget-title lighter smaller">
                                    <i class="ace-icon fa fa-signal blue"></i>
                                    Encuestas completadas por Unidad
                                </h4>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main no-padding">
                                    <div class="dialogs dashboard-unit-stadistic">
                                        <div class="chart-stadistic_unit col-md-12">
                                            <div id="canvas-holder" class="col-xs-12 col-md-6">
                                                <canvas id="chart-area" width="200" height="200"/>
                                            </div>
                                        </div>
                                        <div class="right-btn">
                                            <a href="{{ url('/survey/report') }}" class="btn btn-sm btn-white btn-info">Ver reporte
                                                <i class="ace-icon fa fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div><!-- /.widget-main chart -->
                            </div><!-- /.widget-body chart -->
                        </div><!-- /.widget-box -->
                    </div><!-- /.col -->

                </div><!-- end of row -->

        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('script')
    <script src="{{ asset('/js/chart.min.js') }}"></script>

    <script>

        <?php $colors = array( "#68BC31", "#2091CF", "#DA5430", "#FEE074", "#AF4E96", "#a3be8c", "#96b5b4", "#8fa1b3", "#b48ead" ); ?>

        var doughnutData = [
        <?php
            if(isset($stadistics)){
                foreach($stadistics as $key => $stadistic){
                    $key = $key % 10;
                    echo '{
                        value: '.$stadistic->count.',
                        color:"'.$colors[$key].'",
                        highlight: "'.$colors[$key].'",
                        label: "'.$stadistic->name.'"
                    },';
                }
            }
        ?>
         ];

    </script>

    <script type="text/javascript">
        jQuery(function($) {

            var ctx = document.getElementById("chart-area").getContext("2d");
            window.myDoughnut = new Chart(ctx).Pie(doughnutData, {
                responsive : true,
                animationEasing : "easeOutBounce"
                //animation: false
            });

            var helpers = Chart.helpers;

            var legendHolder = document.createElement('div');
            legendHolder.innerHTML = myDoughnut.generateLegend();
            helpers.each(legendHolder.firstChild.childNodes, function(legendNode, index){
                helpers.addEvent(legendNode, 'mouseover', function(){
                    var activeSegment = myDoughnut.segments[index];
                    activeSegment.save();
                    activeSegment.fillColor = activeSegment.highlightColor;
                    myDoughnut.showTooltip([activeSegment]);
                    activeSegment.restore();
                });
            });
            helpers.addEvent(legendHolder.firstChild, 'mouseout', function(){
                myDoughnut.draw();
            });
            console.log(legendHolder.outerHTML)
            jQuery(".chart-stadistic_unit").append(legendHolder.firstChild);
        });
    </script>
@endsection