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
						<a href="#">Office Expenses</a>
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

					<a href="{{ route('admin.expenses.create')}}" class="btn green">
                        Add New Expense <i class="fa fa-plus"></i>
                    </a>
                    <hr>
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-database"></i>Expense List
							</div>
						</div>

						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="expenses">
								<thead>
									<tr>
										<th>ID.</th>
										<th>Item Name</th>
										<th>Date</th>
										<th>Price ( <span class="fa {{$setting->currency_icon}}"></span> )</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr >
		                                <td>{{-- ID --}}</td>
		                                <td>{{-- Item Name --}}</td>
		                                <td>{{-- Date --}}</td>
		                                <td>{{-- Price --}}</td>
		                                <td>{{-- Action --}} </td>
		                            </tr>
								</tbody>
							</table>
							{{--<a class="btn purple" href="{{ URL::to('admin/expenses/'.$expense->id.'/edit/') }}"><i class="fa fa-edit"></i> View/Edit</a>--}}
							{{--<a class="btn red" href="javascript:;" onclick="del({{$expense->id}},'{{ $expense->itemName }}')"><i class="fa fa-trash"></i> Delete</a>--}}
						</div>
					</div>
					<!-- END EXAMPLE TABLE PORTLET-->
					
				</div>
			</div>
            <!-- BEGIN DASHBOARD STATS -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                <div class="portlet box blue">
	                    <div class="portlet-title">
	                        <div class="caption">
								Expense Chart
	                        </div>
	                    </div>
	                    <div class="portlet-body">
						  <div id="expenseChart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
	                    </div>
	                </div>

                </div>


            <!-- END DASHBOARD STATS -->			
			<!-- END PAGE CONTENT-->

			{{--DELETE MODAL CALLING--}}
                @include('admin.common.delete')
            {{--DELETE MODAL CALLING END--}}
@stop



@section('footerjs')

<!-- BEGIN PAGE LEVEL PLUGINS -->
		{{HTML::script("assets/global/plugins/select2/select2.min.js")}}
    	{{HTML::script("assets/global/plugins/datatables/media/js/jquery.dataTables.min.js")}}
    	{{HTML::script("assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js")}}

    	{{HTML::script("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js")}}
        {{HTML::script("assets/global/plugins/bootstrap-select/bootstrap-select.min.js")}}

        {{HTML::script("assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js")}}
        {{HTML::script("assets/admin/pages/scripts/components-dropdowns.js")}}


		{{HTML::script('assets/admin/pages/scripts/ui-blockui.js')}}
        {{HTML::script("assets/global/plugins/moment.min.js")}}
		<script src="http://code.highcharts.com/highcharts.js"></script>
		<script src="http://code.highcharts.com/modules/exporting.js"></script>
		{{HTML::script("assets/global/scripts/jquery.dataTables.yadcf.js")}} 	

<!-- END PAGE LEVEL PLUGINS -->


<script>


    	$('#expenses').dataTable( {
                    "bProcessing": true,
                    //"bServerSide": true,
                    "sAjaxSource": "{{ URL::route("admin.ajax_expenses") }}",
                    "aaSorting": [[ 1, "asc" ]],
                    "aoColumns": [
                        { 'sClass': 'center', "bSortable": true, 'visible' : false  },
                        { 'sClass': 'center', "bSortable": true },
                        { 'sClass': 'center', "bSortable": true },
                        { 'sClass': 'center', "bSortable": true },
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
                    
         }).yadcf([
	        {
	          	column_number: 0
	        },
	        {
	          	column_number: 1,
	          	filter_type: "text",
	          	filter_delay: 500
	        },
	        {
	          	column_number: 2,
	          	filter_type: "text",
	          	filter_delay: 500
	        },
	        {
	          	column_number: 3,
	          	filter_type: "text",
	          	filter_delay: 500
	        },
	        {
	          	column_number: 4,
	          	filter_type: "range_number_slider",
	          	filter_delay: 500
	        },
	        ]);
         
    		yadcf.exFilterColumn(oTable, [[0, "Trident"]]);;



		function del(id,name)
		{

			$('#deleteModal').appendTo("body").modal('show');
			$('#info').html('Are you sure ! You want to delete <strong>'+name+'</strong> ??');
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
		
		$(function () {

		    $('#expenseChart').highcharts({
		        chart: {
		            type: 'column'
		        },
		        title: {
		            text: 'Monthly Expense Report '+new Date().getFullYear()
		        },
		        xAxis: {
		            categories: [
		                'Jan',
		                'Feb',
		                'Mar',
		                'Apr',
		                'May',
		                'Jun',
		                'Jul',
		                'Aug',
		                'Sep',
		                'Oct',
		                'Nov',
		                'Dec'
		            ],
		            crosshair: true
		        },
		        yAxis: {
		            min: 0,
		            title: {
		            useHTML: true,
		                text: 'Expense in ( <span class="fa {{$setting->currency_icon}}"></span> )'
		            }
		        },
		        tooltip: {
		            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
		            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
		                '<td style="padding:0"><b>{point.y:.1f} <span class="fa {{$setting->currency_icon}}"></span></b></td></tr>',
		            footerFormat: '</table>',
		            shared: true,
		            useHTML: true
		        },
		        plotOptions: {
		            column: {
		                pointPadding: 0.2,
		                borderWidth: 0
		            }
		        },
		        series: [  {
		            name: 'Expense',
		            data: [{{$expense}}]

		        }]
		    });
		});
</script>
@stop
	