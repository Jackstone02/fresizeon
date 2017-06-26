@extends('admin.adminlayouts.adminlayout')

@section('head')

	<!-- BEGIN PAGE LEVEL STYLES -->
	{{HTML::style("assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css")}}
	{{HTML::style("assets/global/plugins/bootstrap-datepicker/css/datepicker3.css")}}
	{{HTML::style("assets/global/plugins/select2/select2.css")}}
	<!-- BEGIN THEME STYLES -->

@stop


@section('mainarea')

			
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Edit Attendance
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="{{route('admin.dashboard.index')}}">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="{{ route('admin.attendances.index') }}">Attendace</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="">Update attendace</a>
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

				<div class="row">
					<div class="form-group">
					{{Form::open(['route'=>["admin.attendances.create"],'class'=>'form-horizontal','id'=>'date_submit','method'=>'GET'])}}
					
						<!-- <div class="col-md-2">
							<select name="department" class="form-control select2me">
								<option value=''>SELECT PROJECT</option>
								@foreach( $department as $id => $dept )
									<option value="{{ $id }}" {{ Input::get('department') == $id ? 'selected' : '' }}>{{ $dept }}</option>
								@endforeach
							</select>
						</div> -->
						<div class="col-md-2">
							<input type="date" class="form-control" name="date" id="date" value="{{ $date }}" placeholder="select another date">
						</div>
						<span class="input-group-btn">
							<button data-loading-text="Redirecting..." class="demo-loading-btn btn blue btn-circle" type="submit"><i class="fa fa-calendar"></i> Filter</button>
						</span>

					{{Form::close()}}
<!--
					<div class="col-md-offset-6 col-md-3 ">
						@if($date!=date('Y-m-d'))
							<a href="{{route('admin.attendances.create')}}" data-loading-text="Redirecting..." class="demo-loading-btn btn green">
								Mark Todays Attendance <i class="fa fa-plus"></i>
							</a>
						@endif
					</div>
-->                   
					</div>
				</div>

				<hr>
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-edit"></i>
								@if(isset($todays_holidays->date))
									Holiday , {{date('d M Y',strtotime($todays_holidays->date))}}
								@else
									Mark Attendance
								@endif
							</div>
							<div class="tools"></div>
						</div>

						<div class="portlet-body form">

						@if(isset($todays_holidays->date))
							<div class="note note-info">
								<h4 class="block">{{date('D', strtotime($todays_holidays->date))}}</h4>
								<p>Holiday on the occassion of {{ $todays_holidays->occassion }}</p>
							</div>
						@elseif(count($employees)==0)
							<hr>
							<div class="note note-warning">
								<h4 class="block">Employees Missing</h4>
								<p>Please add some employees to the database</p>
							</div>
							<hr>
						@else
							<!-- BEGIN FORM-->
							{{Form::open(['route'=>["admin.attendances.update",$date],'class'=>'form-horizontal','method'=>'PATCH'])}}

									<div class="form-body">
										<h3 class="form-section">Date  {{date('d-M-Y',strtotime($date))}}</h3>
										<div class="form-group">
											<label class="col-md-1 control-group">EmployeeID</label>
											<label class="col-md-2 control-group" style="width: 180px">Name</label>
											<label class="col-md-2 control-group" style="width: 150px">Status</label>
											<label class="col-md-2 control-group">Project</label>
											<label class="col-md-2 control-group" style="width: 150px">Time IN</label>
											<label class="col-md-2 control-group" style="width: 150px">Time OUT</label>
											<label class="col-md-2 control-group" style="width: 120px">Work Hours</label>
											<label class="col-md-2 control-group" style="width: 120px">OT Hours</label>
										</div>

										@foreach($employees as $employee)
											<div class="form-group">
												<label class="col-md-1 control-group">{{$employee->employeeID}}</label>
												<label class="col-md-2 control-group" style="width: 180px">{{$employee->fullName}}</label>
												<div class="col-md-2" style="width: 150px">
													<input type="checkbox"  id="checkbox{{$employee->employeeID}}" onchange="showHide('{{$employee->employeeID}}');return false;" class="make-switch" name="checkbox[{{$employee->employeeID}}]" checked data-on-color="success" data-on-text="P" data-off-text="A" data-off-color="danger">
													<input type="hidden"  name="employees[]" value="{{$employee->employeeID}}">
												</div>
												<div class="col-md-2">
													<?php 
														if( !empty($attendanceArray[$employee->employeeID]['department']) ) $deptID = $attendanceArray[$employee->employeeID]['department'];
														else $deptID = $employee->department;
													?>
													{{ Form::select('department['.$employee->employeeID.']', $department,$deptID,['class' => 'form-control select2me department','id'=>'department'.$employee->employeeID.'']) }}
												</div>
												<div class="col-md-2" style="width: 150px">
													<select class="form-control select2me time_in" name="time_in[{{$employee->employeeID}}]" id="time_in{{$employee->employeeID}}">
														<?php
															$options = array();

															$day = date('D',strtotime($date));

															//$i = ( $day == 'Mon' )? "8" : "7";
															//$hrs = ( $day == 'Mon' )? "8" : "9";

															if( $day == 'Mon' )     { $i = "8"; $hrs = "8"; }
															elseif( $day == 'Sat' ) { $i = "7"; $hrs = "5"; }
															else                    { $i = "7"; $hrs = "9"; }

															foreach (range($i,23) as $fullhour) {
																$parthour = $fullhour > 12 ? $fullhour - 12 : $fullhour;
																$sufix = $fullhour > 11 ? " pm" : " am";

																$options["$fullhour:00"] = $parthour.":00".$sufix;
																$options["$fullhour:30"] = $parthour.":30".$sufix;
															}

															foreach( $options as $index => $value ) {
																if( isset($attendanceArray[$employee->employeeID]['time_in']) AND $attendanceArray[$employee->employeeID]['time_in'] == $index ) $selected = 'selected';
																else $selected = '';

																echo "<option value='".$index."' ".$selected.">".$value."</option>";
															}

														?>
													</select>
												</div>
												<div class="col-md-2" style="width: 150px">
													<select class="form-control select2me time_out" name="time_out[{{$employee->employeeID}}]" id="time_out{{$employee->employeeID}}">
														<?php
															foreach( $options as $index => $value ) {
																if( isset($attendanceArray[$employee->employeeID]['time_out']) AND $attendanceArray[$employee->employeeID]['time_out'] == $index ) $selected = 'selected';
																else $selected = '';

																echo "<option value='".$index."' ".$selected.">".$value."</option>";
															}
														?>
													</select>
												</div>
												<div class="col-md-2" style="width: 120px">
													<input type="text" readonly class="form-control work_hours" name="work_hours[{{$employee->employeeID}}]" id="work_hours{{$employee->employeeID}}" value="{{{ $attendanceArray[$employee->employeeID]['work_hours'] or '' }}}">
												</div>
												<div class="col-md-2" style="width: 120px">
													<input type="text" readonly class="form-control overtime" name="overtime[{{$employee->employeeID}}]" id="overtime{{$employee->employeeID}}" value="{{{ $attendanceArray[$employee->employeeID]['overtime'] or '' }}}">
												</div>

											</div>
										@endforeach

										<div class="form-actions">
											<div class="row">
												<div class="col-md-offset-3 col-md-9">
													<button type="submit" data-loading-text="Submitting..." class="demo-loading-btn btn green btn-circle"><i class="fa fa-edit"></i> Submit</button>

											   </div>
										   </div>
									   </div>
											{{ Form::close() }}

						@endif
													<!-- END FORM-->

						</div>
					</div>
					<!-- END EXAMPLE TABLE PORTLET-->
					
				</div>
			</div>
			<!-- END PAGE CONTENT-->



@stop

@section('footerjs')

		<!-- BEGIN PAGE LEVEL PLUGINS -->
		{{ HTML::script("assets/global/plugins/select2/select2.min.js")}}

		{{HTML::script("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js")}}
		{{HTML::script("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js")}}
		{{HTML::script("assets/admin/pages/scripts/components-pickers.js")}}
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
					yearRange: "-100:+0", 
				}); 
			}); 
	   </script>
		<!-- / DATEPICKER -->

<script>
	jQuery(document).ready(function() {
		ComponentsPickers.init();

	});
</script>

<script>

	@foreach($attendanceArray as $attend) {

		@if($attend['status']=='absent')
			$("#department{{$attend['employeeID']}}").hide();
			$("#time_in{{$attend['employeeID']}}").hide();
			$("#ime_out{{$attend['employeeID']}}").hide();
			$("#work_hours{{$attend['employeeID']}}").hide();
			$("#overtime{{$attend['employeeID']}}").hide();

			$("#checkbox{{$attend['employeeID']}}").bootstrapSwitch('state',false);

		@else
			$("#department{{$attend['employeeID']}}").show(100);
			$("#time_in{{$attend['employeeID']}}").show(100);
			$("#time_out{{$attend['employeeID']}}").show(100);
			$("#work_hours{{$attend['employeeID']}}").show(100);
			$("#overtime{{$attend['employeeID']}}").show(100);
		
		@endif
	}
	@endforeach
	 
	function showHide(id){
			
		$("#department" + id).hide();
		$("#time_in" + id).hide();
		$("#ime_out" + id).hide();
		$("#work_hours" + id).hide();
		$("#overtime" + id).hide();


		if( $("#checkbox" + id +":checked").val() == 'on' ) {
			$("#department" + id).show(100);
			$("#time_in" + id).show(100);
			$("#time_out" + id).show(100);
			$("#work_hours" + id).show(100);
			$("#overtime" + id).show(100);

		} else {
			$("#department" + id).hide();
			$("#time_in" + id).hide();
			$("#time_out" + id).hide();
			$("#work_hours" + id).hide();
			$("#overtime" + id).hide();
		}
	}

	$(document).ready(function() {
		
		$(".time_in, .time_out").on("change", function() {
			
			var id = this.id;
			var id_num = id.replace(/\D/g, '');

			calculate(id_num);

		});

		function calculate(id) {
			
			var time1 = $("#time_in" + id).val().split(':'), 
				time2 = $("#time_out" + id).val().split(':');
			var hours1 = parseInt(time1[0], 10), 
				hours2 = parseInt(time2[0], 10),
				mins1 = parseInt(time1[1], 10),
				mins2 = parseInt(time2[1], 10);
			
			var hours = hours2 - hours1, mins = 0;
			
			if( hours < 0 ) hours = 24 + hours;
			if( mins2 >= mins1 ) {
				mins = mins2 - mins1;
			}
			else {
				mins = (mins2 + 60) - mins1;
				hours--;
			}

			mins = mins / 60; // take percentage in 60
			hours += mins;
			hours = hours.toFixed(2);
			//minus 1 hour for the lunch break
			hours--; 
			if( {{ $hrs }} == '5' ) hours++;
			$("#work_hours" + id).val(hours);


			if( $("#work_hours" + id).val() > {{ $hrs }} ) $("#overtime" + id).val( $("#work_hours" + id).val() - {{ $hrs }} );
			else $("#overtime" + id).val( 0 );

			$("#work_hours" + id).val($("#work_hours" + id).val() - $("#overtime" + id).val());
		}

		/*
		$("#date").change(function() {
			$("#date_submit").submit();
		});*/

	});
			

</script>                                                    


@stop