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

				<div class="form-group">
		          {{Form::open(['route'=>["admin.expenses.filter"],'class'=>'form-horizontal','method'=>'GET'])}}
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
		                <span class="input-group-btn">
		                  <button data-loading-text="Redirecting..." class="demo-loading-btn btn blue" type="submit"><i class="fa fa-calendar"></i> Filter</button>
		                </span>
		            </div>

		          </div>
		          {{Form::close()}}
		        </div>
		        


		        {{--@if( $expenses->show == 1 )--}}
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
								<i class="fa fa-database"></i>Expense List
							</div>
							<div class="tools" style="  padding: 5px;">
								<div class="btn-group pull-right">
	        						<a href="{{ $expenses->url }}" class="btn green btn-circle">
				                        Add New Expense <i class="fa fa-plus"></i>
				                    </a>
								</div>
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
								<tfoot>
								    <tr>
								        <th></th>
								        <th style="background-color: #F7F7F7"></th>
							            <th>TOTAL</th>
							            <th></th>
							            <th style="background-color: #F7F7F7"></th>
								    </tr>
								</tfoot>
							</table>
							{{--<a class="btn purple" href="{{ URL::to('admin/expenses/'.$expense->id.'/edit/') }}"><i class="fa fa-edit"></i> View/Edit</a>--}}
							{{--<a class="btn red" href="javascript:;" onclick="del({{$expense->id}},'{{ $expense->itemName }}')"><i class="fa fa-trash"></i> Delete</a>--}}
						</div>
					</div>
					<!-- END EXAMPLE TABLE PORTLET-->
					
				</div>
				
				<!-- BEGIN DASHBOARD STATS -->
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
				{{--@endif--}}
			</div>			
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

<!-- END PAGE LEVEL PLUGINS -->


<script>

		Number.prototype.format = function(n, x) {
		    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
		    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
		};


    	$('#expenses').dataTable( {
                    "bProcessing": true,
                    //"bServerSide": true,
                    "sAjaxSource": "{{ $expenses->table }}",
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
                    },
                    "footerCallback": function ( row, data, start, end, display ) {
			            var api = this.api();
			            var COLNUMBER = 3;
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
		            text: 'Monthly Expense Report {{ Input::get('year') }}'
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
		                '<td style="padding:0"><b><span class="fa {{$setting->currency_icon}}"></span> {point.y:.1f}</b></td></tr>',
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
		            data: [{{$expenses->chart}}]

		        }]
		    });
		});
</script>
@stop
	