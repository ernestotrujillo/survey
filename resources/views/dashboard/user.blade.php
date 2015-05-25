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
                                            <a data-toggle="tab" href="#answer-tab" aria-expanded="false">Encuestas realizadas</a>
                                        </li>

                                        <!--li class="">
                                            <a data-toggle="tab" href="#survey-tab" aria-expanded="false">Encuestas</a>
                                        </li-->
                                    </ul>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main padding-4">
                                    <div class="tab-content padding-8">

                                        <div id="answer-tab" class="tab-pane active">
                                            <!-- #section:pages/dashboard.comments -->
                                            <div class="comments ace-scroll" style="position: relative;">
                                                <div class="scroll-content" style="max-height: 300px;">
                                                    <?php if(isset($last_survey_answer) && count($last_survey_answer) > 0){ ?>
                                                        <?php foreach ($last_survey_answer as $answer): ?>
                                                            <div class="itemdiv commentdiv">
                                                                <div class="elem">
                                                                    <div class="text">
                                                                        <h4 class="blue lighter"><?php echo $answer->survey_name; ?></h4>
                                                                    </div>
                                                                    <div class="name">
                                                                        <label>Usuario:</label>
                                                                        <?php echo $answer->firstname .' '. $answer->lastname; ?>
                                                                    </div>
                                                                    <div class="time">
                                                                        <?php echo $answer->created_at; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php }else{ ?>
                                                        <div>No hay iteraciones.</div>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <div class="hr hr8"></div>

                                            <!--div class="center">
                                                <a href="{{ url('/manager/survey/report') }}" class="btn btn-sm btn-white btn-info">
                                                    Ver todas las encuestas &nbsp;
                                                    <i class="ace-icon fa fa-arrow-right"></i>
                                                </a>
                                            </div>

                                            <div class="hr hr-double hr8"></div-->

                                            <!-- /section:pages/dashboard.comments -->
                                        </div>

                                        <!--div id="survey-tab" class="tab-pane">
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

                                                    <div class="pull-right action-buttons">
                                                        <a href="#" class="blue">
                                                            <i class="ace-icon glyphicon glyphicon-eye-open"></i>
                                                        </a>
                                                    </div>
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

                                        </div-->

                                    </div>
                                </div><!-- /.widget-main -->
                            </div><!-- /.widget-body -->
                        </div><!-- /.widget-box -->
                    </div><!-- /.col -->

                    <div class="col-sm-6">
                        <div class="widget-box transparent">
                            <div class="widget-header">
                                <h4 class="widget-title lighter smaller">
                                    <i class="ace-icon fa fa-signal blue"></i>
                                    Encuestas completadas en mi Area
                                </h4>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main no-padding">
                                    <div class="dialogs dashboard-unit-stadistic">
                                        <div class="chart-stadistic_unit row">
                                            <div id="canvas-holder" class="col-xs-7 col-sm-7 col-md-7 col-md-offset-1">
                                                <canvas id="chart-area" width="100%" height="100%"/>
                                            </div>
                                        </div>
                                        <div class="hr hr8"></div>
                                        <div class="center">
                                            <a href="{{ url('/dashboard/surveys') }}" class="btn btn-sm btn-white btn-info">Realizar encuestas
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
            <?php if(isset($mysurveys_count) && isset($surveys_count)) { ?>
            {
                value: '<?php echo $mysurveys_count; ?>',
                color: "#68BC31",
                highlight: "#68BC31",
                label: "Realizadas"
            },
            {
                value: '<?php echo $surveys_count; ?>',
                color: "#2091CF",
                highlight: "#2091CF",
                label: "No Realizadas"
            },
            <?php } ?>
         ];

    </script>

    <script type="text/javascript">
        jQuery(function($) {

            if(doughnutData.length > 0){
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
            }
            else
            {
                $('#canvas-holder').html('No hay data disponible')
            }
        });
    </script>
@endsection