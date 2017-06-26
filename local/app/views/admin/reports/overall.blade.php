@extends('admin.adminlayouts.adminlayout')

@section('head')

    <!-- BEGIN PAGE LEVEL STYLES -->
        {{HTML::style("assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css")}}
        {{HTML::style("assets/global/plugins/select2/select2.css")}}
        {{HTML::style("assets/global/plugins/jquery-multi-select/css/multi-select.css")}}
        {{HTML::style("assets/global/plugins/fullcalendar/fullcalendar.min.css")}}
    <!-- BEGIN THEME STYLES -->

@stop
@section('mainarea')


            
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                Reports & Statistics 
            </h3>

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="{{route('admin.dashboard.index')}}">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Reports</a>
                    </li>
                </ul>
           
            </div>
            <!-- END PAGE HEADER-->

            <div class="col-md-2">
                <select class="form-control" name="year">
                  <option value="" selected="selected">Year</option>
                  <option value="2017" {{ Input::get('year') == '2017' ? 'selected' : '' }}>2017</option>
                  <option value="2018" {{ Input::get('year') == '2018' ? 'selected' : '' }}>2018</option>
                  <option value="2019" {{ Input::get('year') == '2019' ? 'selected' : '' }}>2019</option>
                  <option value="2020" {{ Input::get('year') == '2020' ? 'selected' : '' }}>2020</option>
                </select>
            </div>
            <br />
            <br />

            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


            <!-- END DASHBOARD STATS -->
@stop

@section('footerjs')

<!-- BEGIN PAGE LEVEL PLUGINS -->
<!--<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>-->
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<!-- END PAGE LEVEL PLUGINS -->


<script>

$(function () {
    Highcharts.chart('container', {
        chart: {
            type: 'line'
        },
        title: {
            text: 'Overall Profit Report'
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: 'Values (₱)'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },
        tooltip: {
            pointFormat: '<b>{point.y}<b>',
            valuePrefix: '₱ '
        },
        series: [{
            name: 'Profit',
            data: [ {{ $profit }} ]
        }]

    });
});
</script>

        
@stop