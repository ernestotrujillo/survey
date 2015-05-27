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
                        <div class="widget-box transparent">
                            <div class="widget-header">
                                <h4 class="widget-title lighter smaller">
                                    <i class="ace-icon fa fa-signal blue"></i>
                                    Encuestas completadas por Unidad
                                </h4>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main no-padding">
                                    <div class="dialogs dashboard-unit-stadistic">
                                        <div class="chart-stadistic_unit row">
                                            <div id="canvas-holder" class="col-xs-7 col-sm-7 col-md-7 col-md-offset-1">
                                                <canvas id="chart-area" width="100%" height="100%">
                                                </canvas>
                                            </div>
                                        </div>
                                        <div class="hr hr8"></div>
                                        <div class="center">
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