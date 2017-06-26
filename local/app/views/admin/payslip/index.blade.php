@extends('admin.adminlayouts.adminlayout')

@section('head')
	
	<!-- BEGIN PAGE LEVEL STYLES -->
	{{HTML::style("assets/global/plugins/select2/select2.css")}}
	{{HTML::style("assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css")}}
	<!-- END PAGE LEVEL STYLES -->

@stop


@section('mainarea')

			
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			{{$pageTitle}}
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="{{route('admin.dashboard.index')}}">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">Payslip</a>
						<i class="fa "></i>
					</li>

				</ul>
			
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div id="load">

                     {{--INLCUDE ERROR MESSAGE BOX--}}
                      @include('admin.common.error')
                     {{--END ERROR MESSAGE BOX--}}

                    </div>

                    <hr>
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-database"></i>Payslip List
							</div>
							<div class="tools" style="  padding: 5px;">
								<div class="btn-group pull-right">
	        						<a  href="{{route('admin.payslip.export') }}" class="btn yellow btn-circle">
								    	<i class="fa fa-file-word-o"></i> Export Payslip
									</a>
								</div>
							</div>
						</div>

						<div class="portlet-body">

							<table class="table table-striped table-bordered table-hover" id="payslip">
							<thead>
							<tr>
								<th style="display:none;">
									 ID
								</th>
								<th>
									 Employee ID
								</th>
								<th>
									 Employee Name
								</th>
								<th>
									 Current Project
								</th>
								<th>
									 Daily Rate ( <span class="fa {{$setting->currency_icon}}"></span> )
								</th>
								<th>
									 Hour Rate ( <span class="fa {{$setting->currency_icon}}"></span> )
								</th>
								<th>
                                     OT Hours
                                </th>
								<th>
									 Days Work
								</th>							
								<th>
									 Action
								</th>
							</tr>
							</thead>
							<tbody>
					

							<tr>
                                <td style="display:none;">{{-- ID --}}</td>
                                <td>{{-- Employee ID --}}</td>
                                <td>{{-- Employee Name --}}</td>
                                <td>{{-- Current Project --}}</td>
                                <td>{{-- Daily Rate --}}</td>
                                <td>{{-- Hour Rate --}}</td>
                                <td>{{-- Overtime --}}</td>
                                <td>{{-- Days Work --}} </td>
                                <td>{{-- Action --}} </td>
                            </tr>

							
					
							</tbody>
							</table>
							{{--<a class="btn purple" href="{{ URL::to('admin/payslip/'.$payslip->id.'/edit/') }}"><i class="fa fa-edit"></i> View/Edit</a>--}}

                            {{--<a class="btn red" href="javascript:;" onclick="del({{$payslip->id}},'{{ $payslip->employeeID }}')"><i class="fa fa-trash"></i> Delete</a>--}}
						</div>
					</div>
					<!-- END EXAMPLE TABLE PORTLET-->
					
				</div>
			</div>
			<!-- END PAGE CONTENT-->

			{{--DELETE MODAL CALLING--}}
                @include('admin.common.delete')
            {{--DELETE MODAL CALLING END--}}
@stop



@section('footerjs')

<!-- BEGIN PAGE LEVEL PLUGINS -->
	{{ HTML::script("assets/global/plugins/select2/select2.min.js")}}
    	{{ HTML::script("assets/global/plugins/datatables/media/js/jquery.dataTables.min.js")}}
    	{{ HTML::script("assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js")}}

<!-- END PAGE LEVEL PLUGINS -->

	<script>


    	$('#payslip').dataTable( {
                    "bProcessing": true,
                    //"bServerSide": true,
                    "sAjaxSource": "{{ URL::route("admin.ajax_payslip") }}",
                    "aaSorting": [[ 1, "asc" ]],
                    "aoColumns": [
                        { 'sClass': 'center', "bSortable": true, 'visible' : false },
                        { 'sClass': 'center', "bSortable": true },
                        { 'sClass': 'center', "bSortable": true },
                        { 'sClass': 'center', "bSortable": true },
                        { 'sClass': 'center', "bSortable": true },
                        { 'sClass': 'center', "bSortable": true },
                        { 'sClass': 'center', "bSortable": true, 'visible' : false },
                        { 'sClass': 'center', "bSortable": true, 'visible' : false },
                        { 'sClass': 'center', "bSortable": false }
                    ],

					"lengthMenu": [
									[5, 15, 20, -1],
									[5, 15, 20, "All"] // change per page values here
								],
                    "sPaginationType": "full_numbers",
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        var row = $(nRow);
                        row.attr("id", 'row'+aData['0']);
                    }

         });



		function del(id,name)
		{

			$('#deleteModal').appendTo("body").modal('show');
			$('#info').html('Are you sure ! You want to delete <strong>'+name+'</strong> ??');
			$("#delete").click(function()
			{
					 $.ajax({

		                type: "DELETE",
		                url : "{{ URL::to('admin/payslip/"+id+"') }}",
		                dataType: 'json',
		                data: {"id":id}

		            	}).done(function(response)
		           		  {

		               	 	 if(response.success == "deleted")
		                 	 {
		                 	 		$("html, body").animate({ scrollTop: 0 }, "slow");
		                  	   		$('#deleteModal').modal('hide');
		                 	  		$('#row'+id).fadeOut(500);
		                 	  		$('#load').html("<p class='alert alert-success text-center'><strong>"+name +"</strong> Successfully Deleted</p>");
		                  	 }
		           		 });
				})

			}
</script>
@stop
	