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
            <a href="">Payslip Details</a>
          </li>
        </ul>
      
      </div>
      <!-- END PAGE HEADER-->
      <!-- BEGIN PAGE CONTENT-->
      <div class="row">

        <div class="form-group">
          {{Form::open(['route'=>["admin.payslip.filter"],'class'=>'form-horizontal','method'=>'GET'])}}
          <div class="col-sm-9">           
            <div class="form-group">
                <input type="hidden"  name="employeeID" value="{{ $payslip->employeeID }}">
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


          <div class="portlet box blue">
            <div class="portlet-title">
              <div class="caption">
                <i class="fa fa-edit"></i>Payslip Details for {{ $payslip->employeeName }}
              </div>
              <div class="tools" style="  padding: 5px;">
                <div class="btn-group pull-right">
                 @if( $payslip->show == 1 )
                    <a  href="{{route('admin.payslip.individualPay',['employeeID' => $payslip->employeeID,'year'=> $_GET['year'],'month'=> $_GET['month'],'pay'=> $_GET['pay']] )}}" class="btn yellow btn-circle">
                    <!--<a  href="{{route('admin.payslip.individualPay',$payslip->employeeID )}}" class="btn yellow" method='GET'>-->
                        <i class="fa fa-file-word-o"></i> Export
                    </a>
                @endif

                </div>
              </div>
            </div>


            <div class="portlet-body form">

            <!-- BEGIN FORM-->
            <!--{{Form::open(array('route'=>["admin.payslip.update",$payslip->id],'class'=>'form-horizontal form-bordered','method'=>'PATCH','files'=>true))}}-->
          @if( $payslip->show == 1 )
                <div class="form-horizontal form-bordered">

                    <div class="form-group">
                        <label class="col-md-2 control-label"><strong>Employee Name</strong></label>
                        <div class="col-md-2">
                            <!--<input type="text" class="form-control" name="employeeName" readonly placeholder="Item Name" value="{{ $payslip->employeeName }}">-->
                            <div class='form-control'>{{ $payslip->employeeName }}</div>
                        </div>
                        
                        <label class="col-md-2 control-label"><strong>Deductions </strong></label>
                        <input type="hidden" class="form-control" name="deductions" readonly placeholder="Deductions" value="{{ $payslip->deductions }}" >

                        <div class="col-md-3">
                        @if( !empty($payslip->reason) ) 
                            @foreach( $payslip->reason as $reason )
                              {{ $reason }}
                            @endforeach 
                        @else
                            <div class='form-control'></div>
                        @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label"><strong>Daily Rate ( <span class="fa {{$setting->currency_icon}}"></span> ): </strong></label>
                        <div class="col-md-2">
                            <!--<input type="text" class="form-control" name="daily_rate" readonly placeholder="Daily Rate" value="{{ $payslip->daily_rate }}" >-->
                            <div class='form-control'>{{ number_format($payslip->daily_rate,2) }}</div>
                        </div>

                        <label class="col-md-2 control-label"><strong>Awards/Bonus </strong></label>
                        <input type="hidden" class="form-control" name="awards" readonly placeholder="Awards" value="{{ $payslip->awards }}" >

                        <div class="col-md-3">
                        @if( !empty($payslip->awardName) ) 
                            @foreach( $payslip->awardName as $award )
                              {{ $award }}
                            @endforeach 
                        @else
                            <div class='form-control'></div>
                        @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label"><strong>Hour Rate ( <span class="fa {{$setting->currency_icon}}"></span> ): </strong></label>
                        <div class="col-md-2">
                            <!--<input type="text" class="form-control" name="hour_rate" readonly placeholder="Hour Rate" value="{{ $payslip->hour_rate }}" >-->
                            <div class='form-control'>{{ number_format($payslip->hour_rate,2) }}</div>
                        </div>

                        <label class="col-md-2 control-label"><strong>Project Hours: </strong></label>
                        <input type="hidden" class="form-control" name="awards" readonly placeholder="Awards" value="{{ $payslip->hours }}" >

                        <div class="col-md-4">
                        @if( !empty($payslip->project_hours) ) 
                            @foreach( $payslip->project_hours as $phours )
                              {{ $phours }}
                            @endforeach 
                        @else
                            <div class='form-control'></div>
                        @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label"><strong>OT Hours</strong></label>
                        <div class="col-md-2">
                            <!--<input type="text" class="form-control" name="overtime" readonly placeholder="OT Hours" value="{{ $payslip->overtime }}">-->
                            <div class='form-control'>{{ $payslip->overtime }}</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label"><strong>No. of days</strong></label>
                        <div class="col-md-2">
                            <!--<input type="text" class="form-control" name="days_work" readonly placeholder="Days Work" value="{{ $payslip->days_work }}">-->
                            <div class='form-control'>{{ $payslip->days_work }}</div>
                        </div>
                    </div>  

                    <div class="form-group">
                        <label class="col-md-2 control-label"></label>
                        <div class="col-md-2">
                            
                        </div>
                        <label class="col-md-2 control-label"><strong>TOTAL SALARY ( <span class="fa {{$setting->currency_icon}}"></span> )</strong></label>
                        <div class="col-md-2">
                            <!--<input type="text" class="form-control" name="salary" readonly placeholder="Salary" value="{{ $payslip->salary }}">-->
                            <div class='form-control'>{{ number_format($payslip->salary,2) }}</div>
                        </div>
                        <div class="col-md-2">
                          <a tclass="form-control" target='_blank' href="https://online.bdo.com.ph/sso/login?josso_back_to=https://online.bdo.com.ph/sso/josso_security_check">LINK</a>
                        </div>
                    </div>                                   

            <!--{{ Form::close() }}-->
              <!-- END FORM-->

                </div>
                @endif
          </div>
          <!-- END EXAMPLE TABLE PORTLET-->
          
        </div>
      </div>
      <!-- END PAGE CONTENT-->



@stop

@section('footerjs')

<!-- BEGIN PAGE LEVEL PLUGINS -->
{{HTML::script("assets/global/plugins/bootstrap-select/bootstrap-select.min.js")}}
{{HTML::script("assets/global/plugins/select2/select2.min.js")}}
{{HTML::script("assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js")}}
<!-- END PAGE LEVEL PLUGINS -->

@stop