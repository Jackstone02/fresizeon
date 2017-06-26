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
						<a href="{{route('admin.projectexpenses.index')}}">Project Expenses</a>
						<i class="fa "></i>
					</li>

				</ul>
			
			</div>
			<!-- END PAGE HEADER-->

			<!-- BEGIN PAGE CONTENT-->
			<div class="row">

				<div class="form-group">        
					{{Form::open(['route'=>["admin.projectexpenses.filter"],'class'=>'form-horizontal','method'=>'GET'])}}
					<div class="col-md-2">
						<select name="department" class="form-control select2me">
							<option value=''>SELECT PROJECT</option>
							@foreach( $department as $id => $dept )
								<option value="{{ $id }}" {{ Input::get('department') == $id ? 'selected' : '' }}>{{ $dept }}</option>
							@endforeach
						</select>
					</div>
					<span class="input-group-btn">
                  		<button data-loading-text="Redirecting..." class="demo-loading-btn btn blue" type="submit"><i class="fa fa-calendar"></i> Filter</button>
                	</span>
                	{{Form::close()}}
		        </div>



		        {{--@if( $projectexpenses->show == 1 )--}}
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
								<i class="fa fa-database"></i>Expense List of {{ $projectexpenses->dept }}
							</div>
							@if( $projectexpenses->show == 1 )
							<div class="tools" style="  padding: 5px;">
								<div class="btn-group pull-right">
	        						<a href="{{ $projectexpenses->url }}" class="btn green btn-circle">
				                        Add New Expenses <i class="fa fa-plus"></i>
				                    </a>
								</div>
							</div>
							@endif
						</div>

						<div class="portlet-body">

							<table class="table table-striped table-bordered table-hover" id="expenses">
								<thead>
									<tr>
										<th>ID.</th>
										<th>Item Type</th>
										<th>Item Name</th>
										<th>Department</th>
										<th>Purchase Date</th>
										<th>Price ( <span class="fa {{$setting->currency_icon}}"></span> )</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr >
		                                <td>{{-- ID --}}</td>
		                                <td>{{-- Item Type --}}</td>
		                                <td>{{-- Item Name --}}</td>
		                                <td>{{-- Department --}}</td>
		                                <td>{{-- Purchase Date --}}</td>
		                                <td>{{-- Price --}}</td>
		                                <td>{{-- Action --}} </td>
		                            </tr>
								<tfoot>
								    <tr>
								        <th></th>
								        <th style="background-color: #F7F7F7"></th>
							            <th style="background-color: #F7F7F7"></th>
							            <th></th>
							            <th>TOTAL</th>
							            <th>Start date</th>
							            <th style="background-color: #F7F7F7"></th>
								    </tr>
								</tfoot>	
							</tbody>
							</table>
							{{--<a class="btn purple" href="{{ URL::to('admin/expenses/'.$expense->id.'/edit/') }}"><i class="fa fa-edit"></i> View/Edit</a>--}}
                            {{--<a class="btn red" href="javascript:;" onclick="del({{$expense->id}},'{{ $expense->itemName }}')"><i class="fa fa-trash"></i> Delete</a>--}}
						</div>
					</div>
					<!-- END EXAMPLE TABLE PORTLET-->
					
				</div>
				{{--@endif--}}
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

		Number.prototype.format = function(n, x) {
		    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
		    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
		};

    	$('#expenses').dataTable( {
                    "bProcessing": true,
                    //"bServerSide": true,
                    "sAjaxSource": "{{ $projectexpenses->table }}",
                    "aaSorting": [[ 4, "desc" ]],
                    "aoColumns": [
                        { 'sClass': 'center', "bSortable": true, 'visible' : false },
                        { 'sClass': 'center', "bSortable": true },
                        { 'sClass': 'center', "bSortable": true },
                        { 'sClass': 'center', "bSortable": true, 'visible' : false },
                        { 'sClass': 'center', "bSortable": true },
                        { 'sClass': 'center', "bSortable": true },
                        { 'sClass': 'center', "bSortable": false }
                    ],
					"lengthMenu": [
									[5, 15, 20, -1],
									[5, 15, 20, "All"] // change per page values here
								],
					//"paging": false,
                    "sPaginationType": "full_numbers",
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        var row = $(nRow);
                        row.attr("id", 'row'+aData['0']);
                    },
                    "footerCallback": function ( row, data, start, end, display ) {
			            var api = this.api();
			            var COLNUMBER = 5;
			            // Remove the formatting to get integer data for summation
			            var intVal = function ( i ) {
			                return typeof i === 'string' ?
			                    i.replace(/[\$,]/g, '')*1 :
			                    typeof i === 'number' ?
			                        i : 0;
			            };
			  
			            // Total over all pages
			            if (api.column(COLNUMBER).data().length) {
			                var total = api
			                .column( COLNUMBER )
			                .data()
			                .reduce( function (a, b) {
			                	return intVal(a) + intVal(b);
			                }) 
			            } else { 
			            	total = 0
			            };
			                 
			            // Total over this page
			            if (api.column(COLNUMBER).data().length) {
			            	var pageTotal = api
			                .column( COLNUMBER, { page: 'current'} )
			                .data()
			                .reduce( function (a, b) {
			                    return intVal(a) + intVal(b);
			                }) 
			            }
			            else { 
			            	pageTotal = 0
			            };

			            // Update footer
			            $( api.column(COLNUMBER).footer() ).html(
			                //'<span class="fa {{$setting->currency_icon}}"></span>'+pageTotal.format(2)
			                (end == 1)? total : total.format(2)
			            );
			        }
                    

         });



		function del(id,name)
		{

			$('#deleteModal').appendTo("body").modal('show');
			$('#info').html('Are you sure you want to delete <strong>'+name+'</strong> ??');
			$("#delete").click(function()
			{
					 $.ajax({

		                type: "DELETE",
		                url : "{{ URL::to('admin/expenses/"+id+"') }}",
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
	