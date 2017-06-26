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
			{{$pageTitle}} <small>Members List</small>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="{{route('admin.dashboard.index')}}">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="{{route('admin.departments.index')}}">Project and Designations</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">Members List</a>
					</li>
				</ul>

			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->

			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div id="load">

                    					@if(Session::get('success'))
                    					    <div class="alert alert-success">{{ Session::get('success') }}</div>
                                        @endif

                    </div>

                         <hr>
					<div class="portlet box blue">

						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-users"></i>Members of {{ $department->deptName }}
							</div>
							<div class="tools" style="  padding: 5px;">
								<div class="btn-group pull-right">
            						<a  href="{{route('admin.employees.export') }}" class="btn yellow btn-circle">
								    	<i class="fa fa-file-excel-o"></i>    Export
									</a>
								</div>
							</div>
						</div>

						<div class="portlet-body">

							<table class="table table-striped table-bordered table-hover" id="sample_employees">
							<thead>
							<tr>
								<th class="text-center">
									 EmployeeID
								</th>
								<th class="text-center">
                                     Image
                                </th>
								<th style="text-align: center">
									 Name
								</th>
								<th class="text-center">
                                	 Project
                                </th>
								<th class="text-center">
                                	 At Work
                                </th>
								<th class="text-center">
									 Phone
								</th>
								<th class="text-center">
									 Status
								</th>
							</tr>
							</thead>
							<tbody>
					
							@foreach ($members as $employee)
                                <tr id="row{{ $employee->employeeID }}">
                                    <td class="text-center">
                                            {{ $employee->employeeID }}

                                    </td>
                                    <td class="text-center">
                                        {{HTML::image("/profileImages/{$employee->profileImage}",'ProfileImage',['height'=>'80px'])}}

                                    </td>
                                    <td>
                                        {{ $employee->fullName }}
                                    </td>
                                    <td class="text-center">
                                        <strong>{{ $employee->getDesignation->department->deptName}}</strong>
                                    	<!--
                                        <p>Project: <strong>{{ $employee->getDesignation->department->deptName}}</strong></p>
                                        <p>Designation: <strong>{{ $employee->getDesignation->designation}}</strong></p>
                                        -->
                                    </td>
                                     <td class="text-center">
                                        {{ $employee->workDuration($employee->employeeID) }}
                                    </td>
                                     <td>
                                        {{ $employee->mobileNumber }}
                                    </td>
                                    <td class="text-center">
                                    @if($employee->status=='active')
                                        <span class="label label-sm label-success"> {{ $employee->status }} </span>
                                    @else
                                        <span class="label label-sm label-danger"> {{ $employee->status }} </span>
                                     @endif
                                    </td>
                                </tr>
							@endforeach
							
					
							</tbody>
							</table>
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
    {{ HTML::script("assets/admin/pages/scripts/table-managed.js")}}
<!-- END PAGE LEVEL PLUGINS -->

	<script>
	    	$('#sample_employees').dataTable( {
                    "bProcessing": true,
                    //"bServerSide": true,
                    "aaSorting": [[ 1, "asc" ]],
                    "aoColumns": [
                        { 'sClass': 'center', "bSortable": true },
                        { 'sClass': 'center', "bSortable": true },
                        { 'sClass': 'center', "bSortable": true },
                        { 'sClass': 'center', "bSortable": true },
                        { 'sClass': 'center', "bSortable": true },
                        { 'sClass': 'center', "bSortable": true },
                        { 'sClass': 'center', "bSortable": true },

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
	</script>
	<script>
	function del(id,name)
    		{
    			$('#deleteModal').appendTo("body").modal('show');
    			$('#info').html('Are you sure ! You want to delete <strong>'+name+'</strong> ??');
    			$("#delete").click(function()
    			{
    					var url = "{{ route('admin.departments.destroy',':id') }}";
						url = url.replace(':id',id);

    					 $.ajax({
    		                type: "DELETE",
    		                url : url,
    		                dataType: 'json',
    		                data: {"id":id}

    		            	}).done(function(response)
    		           		  {

    		               	 	 if(response.success == "deleted")
    		                 	 {
    		                 	 		$("html, body").animate({ scrollTop: 0 }, "slow");
    		                  	   		$('#deleteModal').modal('hide');
    		                 	  		$('#row'+id).closest('tr').remove();
    		                 	  		$('#load').html("<p class='alert alert-success text-center'><strong>"+name +"</strong> Successfully Deleted</p>");
    		                  	 }
    		           		 });
    				})

    			}


	</script>
@stop
	