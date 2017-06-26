@extends('admin.adminlayouts.adminlayout')

@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    {{HTML::style("assets/global/plugins/bootstrap-select/bootstrap-select.min.css")}}
    {{HTML::style("assets/global/plugins/select2/select2.css")}}
    {{HTML::style("assets/global/plugins/jquery-multi-select/css/multi-select.css")}}
    <!-- BEGIN THEME STYLES -->
@stop


@section('mainarea')

      
      <!-- BEGIN PAGE HEADER-->
      <h3 class="page-title">
      Payslip Page
      </h3>
      <div class="page-bar">
        <ul class="page-breadcrumb">
          <li>
            <i class="fa fa-home"></i>
            <a href="{{route('admin.dashboard.index')}}">Home</a>
            <i class="fa fa-angle-right"></i>
          </li>
          <li>
            <a href="{{ route('admin.payslip.index') }}">Payslip</a>
            <i class="fa fa-angle-right"></i>
          </li>
          <li>
            <a href="">Payslip Export</a>
          </li>
        </ul>
      
      </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">

        <div class="form-group">
          {{Form::open(['route'=>["admin.payslip.exporting"],'class'=>'form-horizontal','method'=>'GET'])}}
          <div class="col-sm-9">           
            <div class="form-group">
                <div class="col-md-2">
                    <select class="form-control" name="year">
                      <option value="" selected="selected">Year</option>
                      <option value="2017" {{ Input::get('year') == '2017' ? 'selected' : '' }}>2017</option>
                      <option value="2018" {{ Input::get('year') == '2018' ? 'selected' : '' }}>2018</option>
                      <option value="2019" {{ Input::get('year') == '2019' ? 'selected' : '' }}>2019</option>
                      <option value="2020" {{ Input::get('year') == '2020' ? 'selected' : '' }}>2020</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control" name="month">
                      <option value="" selected="selected">Month</option>
                      <option value="01" {{ Input::get('month') == '01' ? 'selected' : '' }}>January</option>
                      <option value="02" {{ Input::get('month') == '02' ? 'selected' : '' }}>February</option>
                      <option value="03" {{ Input::get('month') == '03' ? 'selected' : '' }}>March</option>
                      <option value="04" {{ Input::get('month') == '04' ? 'selected' : '' }}>April</option>
                      <option value="05" {{ Input::get('month') == '05' ? 'selected' : '' }}>May</option>
                      <option value="06" {{ Input::get('month') == '06' ? 'selected' : '' }}>June</option>
                      <option value="07" {{ Input::get('month') == '07' ? 'selected' : '' }}>July</option>
                      <option value="08" {{ Input::get('month') == '08' ? 'selected' : '' }}>August</option>
                      <option value="09" {{ Input::get('month') == '09' ? 'selected' : '' }}>September</option>
                      <option value="10" {{ Input::get('month') == '10' ? 'selected' : '' }}>October</option>
                      <option value="11" {{ Input::get('month') == '11' ? 'selected' : '' }}>November</option>
                      <option value="12" {{ Input::get('month') == '12' ? 'selected' : '' }}>December</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control" name="pay">
                      <option value="" selected="selected">Payment</option>
                      <option value="1" {{ Input::get('pay') == '1' ? 'selected' : '' }}>1st Pay</option>
                      <option value="2" {{ Input::get('pay') == '2' ? 'selected' : '' }}>2nd Pay</option>
                    </select>
                </div>
                <span class="input-group-btn">
                  <button data-loading-text="Redirecting..." class="demo-loading-btn btn blue" type="submit"><i class="fa fa-calendar"></i> Filter</button>
                </span>
            </div>

          </div>
          {{Form::close()}}
        </div>

        <div class="col-md-12">
          <!-- BEGIN EXAMPLE TABLE PORTLET-->

                {{--INLCUDE ERROR MESSAGE BOX--}}
                @include('admin.common.error')
                {{--END ERROR MESSAGE BOX--}}

        {{Form::open(['route'=>["admin.payslip.exportPayslips"],'class'=>'form-horizontal','method'=>'GET'])}}
        <!-- FOR THE FILTER -->
        <!--<input type="hidden" name="project2" value="{{ Input::get('project') }}">-->
        <input type="hidden" name="year2" value="{{ Input::get('year') }}">
        <input type="hidden" name="month2" value="{{ Input::get('month') }}">
        <input type="hidden" name="pay2" value="{{ Input::get('pay') }}">
        <!-- FOR THE FILTER -->

        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-edit"></i>Employees
                </div>
                <div class="tools" style="  padding: 5px;">
                    <div class="btn-group pull-right">
                        <button data-loading-text="Redirecting..." class="demo-loading-btn btn yellow btn-circle" type="submit"><i class="fa fa-calendar"></i> Export to Word</button>
                    </div>
                </div>
            </div>

            <div class="portlet-body form">

                <div class="form-horizontal form-bordered">

                    @if( $payslip->show == 1 )
                        @foreach( $employees as $employee )
                        <div class="form-group">
                            <input type="checkbox" name="{{ $employee->employeeID }}" id="fancy-checkbox-success checkbox{{ $employee->employeeID }}" autocomplete="off" />
                            <div class="btn-group">
                                <label for="fancy-checkbox-success checkbox{{ $employee->employeeID }}" class="btn btn-success">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span> </span>
                                </label>
                                <label for="fancy-checkbox-success checkbox{{ $employee->employeeID }}" class="btn btn-default active" style="width: 130px">
                                    {{ $employee->fullName }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    @endif

                </div>

            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
          
        </div>
        {{Form::close()}}
    </div>
    <!-- END PAGE CONTENT-->



@stop

@section('footerjs')

<!-- BEGIN PAGE LEVEL PLUGINS -->
{{HTML::script("assets/global/plugins/bootstrap-select/bootstrap-select.min.js")}}
{{HTML::script("assets/global/plugins/select2/select2.min.js")}}
{{HTML::script("assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js")}}
<!-- END PAGE LEVEL PLUGINS -->

<style type="text/css">
    .form-group input[type="checkbox"] {
        display: none;
    }

    .form-group input[type="checkbox"] + .btn-group > label span {
        width: 20px;
    }

    .form-group input[type="checkbox"] + .btn-group > label span:first-child {
        display: none;
    }
    .form-group input[type="checkbox"] + .btn-group > label span:last-child {
        display: inline-block;   
    }

    .form-group input[type="checkbox"]:checked + .btn-group > label span:first-child {
        display: inline-block;
    }
    .form-group input[type="checkbox"]:checked + .btn-group > label span:last-child {
        display: none;   
    }
</style>

@stop