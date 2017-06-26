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
            Overtime page
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="{{route('admin.dashboard.index')}}">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="{{ route('admin.overtime.index') }}">Overtime</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="">Add Overtime</a>
                    </li>
                </ul>
            
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->

                {{--INLCUDE ERROR MESSAGE BOX--}}
                      @include('admin.common.error')
                {{--END ERROR MESSAGE BOX--}}


                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-clock-o"></i>Add Overtime
                            </div>
                            <div class="tools">
                            </div>
                        </div>

                        <div class="portlet-body form">

                        <!-- BEGIN FORM-->
                        {{Form::open(array('url'=>"admin/overtime",'class'=>'form-horizontal form-bordered','method'=>'POST'))}}
                        
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Employee name:</label>
                                <div class="col-md-8">
                                 {{ Form::select('employeeID', $employees,null,['class' => 'form-control input-xlarge select2me','data-placeholder'=>'Select Employee...']) }}
                                </div>
                            </div>

                             <div class="form-group">
                                <label class="col-md-2 control-label">No. of Hrs: </label>
                                <div class="col-md-5">
                                    <input type="number" step="0.01" class="form-control" name="time" placeholder="No. of Hrs" value="{{ Input::old('time') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Reason: </label>
                                <div class="col-md-5">                                    
                                    <textarea class="form-control" name="reason" placeholder="Reason" rows="4">{{ Input::old('reason') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Date:</label>
                                <div class="col-md-5">
                                    <input type="date" class="form-control" name="date" placeholder="Date" value="{{ Input::old('date') }}">
                                </div>
                            </div>
                             
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" data-loading-text="Submitting..." class="demo-loading-btn btn green"><i class="fa fa-check"></i> Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                                {{ Form::close() }}
                                    <!-- END FORM-->
                          
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
<!-- DATEPICKER -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="http://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <script> 
        $(function() { 
            $("input[type='date']").attr('type','text').datepicker({ 
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
            }); 
        }); 
    </script>
<!-- / DATEPICKER -->
@stop