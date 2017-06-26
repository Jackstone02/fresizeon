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
/*
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Overall Report'
    },
    xAxis: {
        categories: [{{ $departments->alldept }}]
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Materials Expenses',
        data: [{{ $departments->total_expenses }}]
    }, {
        name: 'Materials Profit',
        data: [{{ $departments->total_expenses_profit }}]        
    
    }, {
        name: 'Labor Expenses',
        data: [{{ $departments->total_labor }}]        
    
    }, {
        name: 'Labor Profit',
        data: [{{ $departments->total_labor_profit }}]        
    
    }]
});*/
$(function () {
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Profit Report per Project'
        },
        xAxis: {
            type: 'category'
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                }
            }
        },
        tooltip: {
            pointFormat: '<b>{point.y}<b>',
            valueSuffix: ' %'
        },
        series: [{
            name: 'Projects',
            colorByPoint: true,
            data: [{{ $departments->series }}]
        }],
        drilldown: {
            series: [{{ $departments->drilldown }}]
        }

    });
});
</script>

        
@stop