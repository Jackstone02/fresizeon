@extends('admin.adminlayouts.adminlayout')

@section('head')
    <!-- BEGIN PAGE LEVEL STYLES -->
    {{ HTML::style("assets/global/plugins/bootstrap-datepicker/css/datepicker3.css") }}
    {{ HTML::style("assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css") }}
    <!-- BEGIN THEME STYLES -->
@stop


@section('mainarea')

			
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			{{$pageTitle}} Add page
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="{{route('admin.dashboard.index')}}">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="{{ $link }}">Project Expenses</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="">Add Items</a>
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
								<i class="fa fa-plus"></i>Add New Items for {{ $dept }}
							</div>
							<div class="tools"></div>
						</div>

						<div class="portlet-body form">
                        
						<!-- BEGIN FORM-->
						{{Form::open(array('route'=>"admin.projectexpenses.store",'class'=>'form-horizontal form-bordered','method'=>'POST','files'=>true))}}
                        <div class="expenses">
                            <div class="form-group">
                                <div class="btn-group">
                                    <a href="" class="btn green btn-circle" id="add_expense">
                                        Add More Items <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                                <div class="col-md-2">
                                    <input type="hidden" class="form-control" name="department[]" value="{{ Input::get('department') }}">
                                    <input type="text" class="form-control" name="itemName[]" placeholder="Item Name" value="{{ Input::old('itemName') }}" required>
                                </div>


                                <div class="col-md-2">
                                    <select name="type[]" class="form-control">
                                        <option value="1">Architectural/Civil</option>
                                        <option value="2">Electrical</option>
                                        <option value="3">Plumbing</option>
                                        <option value="4">Mechanical</option>
                                        <option value="5">Electronics (cctv/data/related works)</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <input type="date" class="form-control" name="purchaseDate[]" placeholder="Select Purchase Date" readonly>
                                </div>

                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="price[]" placeholder="Price of Item" value="{{ Input::old('price') }}" required>
                                </div>

                                <div class="form-group" style="display:none">
                                    <label class="col-md-2 control-label">Attach Bill:</label>
                                    <div class="col-md-6">
                                       <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="input-group input-large">
                                                <div class="form-control uneditable-input" data-trigger="fileinput">
                                                    <i class="fa fa-file fileinput-exists"></i>&nbsp; <span class="fileinput-filename"></span>
                                                </div>
                                                <span class="input-group-addon btn default btn-file">
                                                    <span class="fileinput-new">Select file </span>
                                                    <span class="fileinput-exists">Change </span>
                                                    <input type="file" name="bill">
                                                </span>
                                                <a href="#" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">Remove </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
						    </div>
                        </div>

                            <div class="form-group">
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit" data-loading-text="Submitting..." class="demo-loading-btn btn green btn-circle"><i class="fa fa-check"></i> Submit</button>
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
{{ HTML::script("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js") }}
{{ HTML::script("assets/admin/pages/scripts/components-pickers.js") }}
{{ HTML::script("assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js") }}
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
                }).datepicker("setDate", new Date()); 
            }); 
       </script>
<!-- / DATEPICKER -->
<script>
jQuery(document).ready(function() {

           ComponentsPickers.init();
            //dept();

        });

</script>
<script>
$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".expenses"); //Fields wrapper
    var add_button      = $("#add_expense"); //Add button ID


    var div = '';
        div += '<div class="form-group">';
            div += '<div class="col-md-2">';
                div += '<input type="hidden" class="form-control" name="department[]" value="{{ Input::get('department') }}">';
                div += '<input type="text" class="form-control" name="itemName[]" placeholder="Item Name" value="{{ Input::old('itemName') }}" required>';
            div += '</div>';
            div += '<div class="col-md-2">';
                div += '<select name="type[]" class="form-control">';
                    div += '<option value="1">Architectural/Civil</option>';
                    div += '<option value="2">Electrical</option>';
                    div += '<option value="3">Plumbing</option>';
                    div += '<option value="4">Mechanical</option>';
                    div += '<option value="5">Electronics (cctv/data/related works)</option>';
                div += '</select>';
            div += '</div>';
            div += '<div class="col-md-2">';
                div += '<input type="date" class="form-control" name="purchaseDate[]" placeholder="Select Purchase Date" readonly>';
            div += '</div>';
            div += '<div class="col-md-2">';
                div += '<input type="text" class="form-control" name="price[]" placeholder="Price of Item" value="{{ Input::old('price') }}" required>';
            div += '</div>';
            div += '<div class="col-md-2"><a href="#" class="btn red btn-circle remove_field">Remove</a></div>';
        div += '</div>';
    
    var x = 1; //initlal text box count
    $(add_button).on("click",function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment

            $(wrapper).append(div); //add input box
        }

        $(function() { 
            $("input[type='date']").attr('type','text').datepicker({ 
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0", 
            }).datepicker("setDate", new Date()); 
        });

        $(".form-control").validate(); //to validate the added inputs


    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent().parent('div').remove(); x--;
    })
});

</script>
@stop