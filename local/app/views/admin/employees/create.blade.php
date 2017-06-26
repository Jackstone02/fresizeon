@extends('admin.adminlayouts.adminlayout')

@section('head')

	<!-- BEGIN PAGE LEVEL STYLES -->
	{{HTML::style('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}
	{{HTML::style('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css')}}
	<!-- END PAGE LEVEL STYLES -->

@stop


@section('mainarea')

        			<!-- BEGIN PAGE HEADER-->
        			<h3 class="page-title">
        			<span class="fa fa-plus"></span>    New Employee
        			</h3>
        			<div class="page-bar">
        				<ul class="page-breadcrumb">
        					<li>
        						<i class="fa fa-home"></i>
        						<a href="index.html">Home</a>
        						<i class="fa fa-angle-right"></i>
        					</li>
        					<li>
        						<a href="{{route('admin.employees.index')}}">Employees</a>
        						<i class="fa fa-angle-right"></i>
        					</li>
        					<li>
                                <a href="#">New Employee</a>
                            </li>
        				</ul>
        			</div>
        			<!-- END PAGE HEADER-->

					@if(count($department)==0)
					 <div class="note note-warning">
                    							   {{Lang::get('messages.noDept')}}
				    </div>
					@else
					<div class="row">
							<div class="col-md-6">


							</div>
							<!--<div class="col-md-6 form-group text-right">

							<span id="load_notification"></span>
								 <input  type="checkbox"  onchange="ToggleEmailNotification('employee_add');return false;" class="make-switch" name="employee_add" @if($setting->employee_add==1)checked	@endif data-on-color="success" data-on-text="Yes" data-off-text="No" data-off-color="danger">
								<strong>Email Notification</strong><br>


							</div>-->
						 </div>

        			{{--INLCUDE ERROR MESSAGE BOX--}}
                            @include('admin.common.error')
                     {{--END ERROR MESSAGE BOX--}}
                                    <hr>
        			<div class="clearfix">
        			</div>
        			{{Form::open(array('route'=>"admin.employees.store",'class'=>'form-horizontal','method'=>'POST','files' => true))}}
        			<div class="row ">
        				<div class="col-md-6 col-sm-6">
        					<div class="portlet box purple-wisteria">
        						<div class="portlet-title">
        							<div class="caption">
        								<i class="fa fa-calendar"></i>Personal Details
        							</div>

        						</div>
        						<div class="portlet-body">

        								<div class="form-body">
                        <div class="form-group ">
        										<label class="control-label col-md-3">Photo</label>
        										<div class="col-md-9">
        											<div class="fileinput fileinput-new" data-provides="fileinput">
        												<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
        												  <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>

        												</div>
        												<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
        												</div>
        												<div>
        													<span class="btn default btn-file">
        													<span class="fileinput-new">
        													Select image </span>
        													<span class="fileinput-exists">
        													Change </span>
        													 <input type="file" name="profileImage">
        													</span>
        													<a href="#" class="btn red fileinput-exists" data-dismiss="fileinput">
        													Remove </a>
        												</div>
        											</div>
        											<div class="clearfix margin-top-10">
                                                        <span class="label label-danger">
                                                        NOTE! </span> &nbsp;Image Size must be (872px by 724px)

                                                    </div>
        											</div>
        										</div>
        									<div class="form-group">
        										<label class="col-md-3 control-label">Name <span class="required">* </span></label>
        										<div class="col-md-9">
        											<input type="text" class="form-control" name="fullName" placeholder="Employee Name" value="{{ Input::old('fullName') }}">
        										</div>
        									</div>
        									<div class="form-group">
        										<label class="col-md-3 control-label">Father's Name</label>
        										<div class="col-md-9">
        											 <input type="text" class="form-control" name="fatherName" placeholder="Father Name">
        										</div>
        									</div>
        									<div class="form-group">
        										<label class="control-label col-md-3">Date of Birth</label>
        										<div class="col-md-3">
                                                    <input type="date" class="form-control" name="date_of_birth" placeholder="yyyy-mm-dd" value="{{ Input::old('date_of_birth') }}">
        											<!--<div class="input-group input-medium date date-picker"  data-date-format="dd-mm-yyyy" data-date-viewmode="years">
        												
        												<span class="input-group-btn">
        												<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
        												</span>
        											</div>-->
        										</div>
        									</div>
        									<div class="form-group">
        										<label class="col-md-3 control-label">Gender</label>
        										<div class="col-md-9">
        											 {{ Form::select('gender', array('male' => 'Male', 'female' => 'Female'), Input::old('gender'),array('class'=>'form-control')) }}
        										</div>
        									</div>

        									<div class="form-group">
        										<label class="col-md-3 control-label">Phone</label>
        										<div class="col-md-9">
        											 <input type="number" class="form-control" name="mobileNumber" placeholder="Contact Number" value="{{Input::old('mobileNumber')}}">
        										</div>
        									</div>
        									<div class="form-group">
        										<label class="col-md-3 control-label">Local Address</label>
        										<div class="col-md-9">
        											<textarea class="form-control" name="localAddress" rows="3">{{Input::old('localAddress')}}</textarea>
        										</div>
        									</div>
        									<div class="form-group">
        										<label class="col-md-3 control-label">Permanent Address</label>
        										<div class="col-md-9">
        											<textarea class="form-control" name="permanentAddress" rows="3">{{Input::old('permanentAddress')}}</textarea>
        										</div>
        									</div>
<!-- removed -jack 12.02.2016
								<h4><strong>Account Login</strong></h4>
        									<div class="form-group">
                                                    <label class="col-md-3 control-label">Email<span class="required">* </span></label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="email" class="form-control" value="{{ Input::old('email') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Password<span class="required">* </span></label>
                                                    <div class="col-md-9">
                                                        <input type="hidden" name="oldpassword">
                                                        <input type="text" name="password" class="form-control" value="{{ Input::old('password') }}">
                                                    </div>
                                                </div>
-->

<input type="hidden" name="email" class="form-control" value="test@test.com">
<input type="hidden" name="oldpassword">
<input type="hidden" name="password" class="form-control" value="testtesttest">
        								</div>

        						</div>
        					</div>
        				</div>
        				<div class="col-md-6 col-sm-6">
        					<div class="portlet box red-sunglo">
        						<div class="portlet-title">
        							<div class="caption">
        								<i class="fa fa-calendar"></i>Company Details
        							</div>

        						</div>
        						<div class="portlet-body">

        								<div class="form-body">
        									<div class="form-group">
        										<label class="col-md-3 control-label">Employee ID<span class="required">* </span></label>
        										<div class="col-md-9">
        											<input type="number" class="form-control" name="employeeID" readonly placeholder="Employee ID" value="{{{ $new->employeeID or '10001' }}}">
        										</div>
        									</div>
        									<div class="form-group">
        										<label class="col-md-3 control-label">Project</label>
        										<div class="col-md-9">
        											  {{ Form::select('department', $department,null,['class' => 'form-control select2me','id'=>'department','onchange'=>'dept();return false;']) }}
        										</div>
        									</div>
        									<div class="form-group" style="display:none">
        										<label class="col-md-3 control-label">Designation</label>
        										<div class="col-md-9">

        											 <select  class="select2me form-control" name="designation" id="designation" >

                                                     </select>
        										</div>
        									</div>
        									<div class="form-group">
        										<label class="control-label col-md-3">Date of Joining</label>
        										<div class="col-md-4">
                                                    <input type="date" class="form-control" name="joiningDate" placeholder="yyyy-mm-dd" value="{{Input::old('joiningDate')}}">
        											<!--<div class="input-group input-medium date date-picker"  data-date-format="dd-mm-yyyy" data-date-viewmode="years">
        												<input type="text" class="form-control" name="joiningDate" readonly value="{{Input::old('joiningDate')}}">
        												<span class="input-group-btn">
        												<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
        												</span>
        											</div>-->
        										</div>
        									</div>
        									<div class="form-group">
        										<label class="col-md-3 control-label">Daily Rate</label>
        										<div class="col-md-9">
        											<input type="number" class="form-control" name="daily_rate" placeholder="Daily Rate" value="{{ Input::old('daily_rate') }}">
        										</div>
        									</div>
        								</div>

        						</div>
        					</div>

        					<div class="portlet box red-sunglo">
        						<div class="portlet-title">
        							<div class="caption">
        								<i class="fa fa-calendar"></i>Bank Account Details
        							</div>

        						</div>
        						<div class="portlet-body">

        								<div class="form-body">
        									<div class="form-group">
        										<label class="col-md-3 control-label">Account Holder Name</label>
        										<div class="col-md-9">
        											<input type="text" class="form-control" name="accountName" placeholder="Account Holder Name" value="{{Input::old('accountName')}}">
        										</div>
        									</div>
        									<div class="form-group">
        										<label class="col-md-3 control-label">Account Number</label>
        										<div class="col-md-9">
        											<input type="text" class="form-control" name="accountNumber" placeholder="Account Number" value="{{Input::old('accountNumber')}}">
        										</div>
        									</div>
        									<div class="form-group">
        										<label class="col-md-3 control-label">Bank Name</label>
        										<div class="col-md-9">
        											<input type="text" class="form-control" name="bank" placeholder="BANK Name" value="{{Input::old('bank')}}">
        										</div>
        									</div>
        									<div class="form-group">
        										<label class="col-md-3 control-label">IFSC Code</label>
        										<div class="col-md-9">
        											<input type="text" class="form-control" name="ifsc" placeholder="IFSC Code" value="{{Input::old('ifsc')}}">
        										</div>
        									</div>
        									<div class="form-group">
                                                <label class="col-md-3 control-label">PAN Number </label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="pan" placeholder="PAN Number" value="{{Input::old('pan')}}">
                                                </div>
                                            </div>
        									<div class="form-group">
        										<label class="col-md-3 control-label">Branch</label>
        										<div class="col-md-9">
        											 <input type="text" class="form-control" name="branch" placeholder="BRANCH" value="{{Input::old('branch')}}">
        										</div>
        									</div>
        								</div>

        						</div>
        					</div>
        				</div>
        			</div>
        			<div class="clearfix">
        			{{---------------Documents------------------}}
        			<div class="row ">
        				<div class="col-md-12 col-sm-12">
        					<div class="portlet box purple-wisteria">
        						<div class="portlet-title">
        							<div class="caption">
        								<i class="fa fa-calendar"></i>Documents
        							</div>

        						</div>
        						<div class="portlet-body">

        								<div class="form-body">
        									<div class="form-group">
        										<label class="control-label col-md-2">Resume</label>
        										<div class="col-md-5">
        											<div class="fileinput fileinput-new" data-provides="fileinput">
        												<div class="input-group input-large">
        													<div class="form-control uneditable-input" data-trigger="fileinput">
        														<i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename">
        														</span>
        													</div>
        													<span class="input-group-addon btn default btn-file">
        													<span class="fileinput-new">
        													Select file </span>
        													<span class="fileinput-exists">
        													Change </span>
        													<input type="file" name="resume">
        													</span>
        													<a href="#" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
        													Remove </a>
        												</div>
        											</div>
        										</div>

        									</div>
        									<div class="form-group">
        										<label class="control-label col-md-2">Offer Letter</label>
        										<div class="col-md-5">
        											<div class="fileinput fileinput-new" data-provides="fileinput">
        												<div class="input-group input-large">
        													<div class="form-control uneditable-input" data-trigger="fileinput">
        														<i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename">
        														</span>
        													</div>
        													<span class="input-group-addon btn default btn-file">
        													<span class="fileinput-new">
        													Select file </span>
        													<span class="fileinput-exists">
        													Change </span>
        													<input type="file" name="offerLetter">
        													</span>
        													<a href="#" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
        													Remove </a>
        												</div>
        											</div>
        										</div>

        									</div>
        									<div class="form-group">
        										<label class="control-label col-md-2">Joining Letter</label>
        										<div class="col-md-5">
        											<div class="fileinput fileinput-new" data-provides="fileinput">
        												<div class="input-group input-large">
        													<div class="form-control uneditable-input" data-trigger="fileinput">
        														<i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename">
        														</span>
        													</div>
        													<span class="input-group-addon btn default btn-file">
        													<span class="fileinput-new">
        													Select file </span>
        													<span class="fileinput-exists">
        													Change </span>
        													<input type="file" name="joiningLetter">
        													</span>
        													<a href="#" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
        													Remove </a>
        												</div>
        											</div>
        										</div>

        									</div>
        									<div class="form-group">
        										<label class="control-label col-md-2">Contract and Agreement</label>
        										<div class="col-md-5">
        											<div class="fileinput fileinput-new" data-provides="fileinput">
        												<div class="input-group input-large">
        													<div class="form-control uneditable-input" data-trigger="fileinput">
        														<i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename">
        														</span>
        													</div>
        													<span class="input-group-addon btn default btn-file">
        													<span class="fileinput-new">
        													Select file </span>
        													<span class="fileinput-exists">
        													Change </span>
        													<input type="file" name="contract">
        													</span>
        													<a href="#" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
        													Remove </a>
        												</div>
        											</div>
        										</div>

        									</div>
        									<div class="form-group">
        										<label class="control-label col-md-2">ID Proof</label>
        										<div class="col-md-5">
        											<div class="fileinput fileinput-new" data-provides="fileinput">
        												<div class="input-group input-large">
        													<div class="form-control uneditable-input" data-trigger="fileinput">
        														<i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename">
        														</span>
        													</div>
        													<span class="input-group-addon btn default btn-file">
        													<span class="fileinput-new">
        													Select file </span>
        													<span class="fileinput-exists">
        													Change </span>
        													<input type="file" name="IDProof">
        													</span>
        													<a href="#" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">
        													Remove </a>
        												</div>
        											</div>
        										</div>

        									</div>
        								</div>

        						</div>
        					</div>
        				</div>
        			</div>
        			<div class="clearfix">
        			</div>
        			<div class="form-actions">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                      <button type="submit" data-loading-text="Submitting..." class="demo-loading-btn btn green btn-circle">
														<i class="fa fa-plus"></i>	Submit </button>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                    </div>

        		</div>
        			</form>
        		@endif
<hr>

@stop



@section('footerjs')


<!-- BEGIN PAGE LEVEL PLUGINS -->
    {{HTML::script('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}
    {{HTML::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}
    {{HTML::script("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js")}}
    {{HTML::script('assets/admin/pages/scripts/components-pickers.js')}}
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




<script>
        jQuery(document).ready(function() {

           ComponentsPickers.init();
            dept();



        });
        function dept(){

                              $.getJSON("{{ URL::to('admin/departments/ajax_designation/')}}",
                              { deptID: $('#department').val() },
                              function(data) {
                                  var model = $('#designation');
                                   model.empty();
                                  $.each(data, function(index, element) {
                                      model.append("<option value='"+element.id+"'>" + element.designation + "</option>");
                                  });

                             });

                        }

    </script>
@stop
