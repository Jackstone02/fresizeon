<?php

//Admin Reports controller

class ReportsController extends \AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
	    $this->data['reportsOpen'] 	= 'active';
	    $this->data['pageTitle']    = 'Dashboard';

    }

// Reports view page   controller
	public function index()
	{

		$this->data['reportsActive']    =   'active';

		$year	= (Input::get('year') != '') ? Input::get('year') : date('Y');

		$this->data['departments'] 		= 	Department::all();
		$this->data['projectexpenses']  =   Expense::all();
		$this->data['employees']  		=   Salary::lists('hour_rate','employeeID');

		foreach( $this->data['departments'] as $department ) {
			$deptname[$department->id] 		= 	"'".$department->deptName."'";
			$budget[$department->id] 		= 	$department->budget;
			$materials[$department->id] 	= 	$department->materials;
			$labor[$department->id] 		= 	$department->labor;
			$expenses[$department->id] 		= 	DB::select("select sum(price) as total from expenses where department=".$department->id);			

			foreach( $this->data['employees'] as $employeeID => $hour_rate ) {
				
				$total_work_hours 						= 	DB::select("select sum(work_hours) as work_hours from attendance where department=".$department->id." AND employeeID=".$employeeID);
				$total_overtime							= 	DB::select("select sum(overtime) as overtime from attendance where department=".$department->id." AND employeeID=".$employeeID);
				//$rate[$department->id][$employeeID] 	= 	$total_work_hours[0]->work_hours * $hour_rate;
				$work_hours_rate						= 	$total_work_hours[0]->work_hours * $hour_rate;
				$overtime_rate 							= 	$total_overtime[0]->overtime * $hour_rate;
				$rate[$department->id][$employeeID] 	= 	$work_hours_rate + $overtime_rate;
			}
		}

		foreach( $rate as $id => $arr ) {
			$total_labor_money[$id] 		= array_sum($arr);
			$total_labor_profit_money[$id] 	= $labor[$id] - $total_labor_money[$id];
			$total_labor[$id] 				= number_format(array_sum($arr)/$labor[$id],4);
			$total_labor_profit[$id] 		= number_format(1-(array_sum($arr)/$labor[$id]),4);
		}

		foreach( $expenses as $id => $sum ) {
			$total_expenses_money[$id] 			= $sum[0]->total;
			$total_expenses_profit_money[$id] 	= $materials[$id]  - $total_expenses_money[$id] ;
			$total_expenses[$id] 				= number_format($sum[0]->total/$materials[$id],4);
			$total_expenses_profit[$id] 		= number_format(1-($sum[0]->total/$materials[$id]),4);
		}

		foreach( $deptname as $deptid => $dept ) {
			$budget_percent[$deptid] = number_format(1-($total_expenses_money[$deptid] + $total_labor_money[$deptid])/$budget[$deptid],4);
			$budget_money[$deptid] = $budget[$deptid] - ($total_expenses_money[$deptid] + $total_labor_money[$deptid]);
		}
		//return dd($budget_money);
		
		$this->data['departments']->alldept = implode(",", $deptname);
		$this->data['departments']->total_expenses = implode(",", $total_expenses);
		$this->data['departments']->total_labor = implode(",", $total_labor);
		$this->data['departments']->total_expenses_profit = implode(",", $total_expenses_profit);
		$this->data['departments']->total_labor_profit = implode(",", $total_labor_profit);
		
		//return dd($deptname);

        $series = "";
        $drilldown = "";
        foreach( $deptname as $deptid => $dept ) {
        	$merged = "'".str_replace("'","",$dept)."<br/>₱".number_format($budget_money[$deptid],2)."'";
        	$series .= "{
        		name: ".$merged.",
        		y: ".$budget_percent[$deptid].",
        		drilldown: ".$dept."
        	},";

        	$drilldown .= "{
                id: ".$dept.",
                data: [
                    ['Materials Expenses<br>₱".number_format($total_expenses_money[$deptid],2)."', ".$total_expenses[$deptid]."],
                    ['Materials Profit<br>₱".number_format($total_expenses_profit_money[$deptid],2)."', ".$total_expenses_profit[$deptid]."],
                    ['Labor Expenses<br>₱".number_format($total_labor_money[$deptid],2)."', ".$total_labor[$deptid]."],
                    ['Labor Profit<br>₱".number_format($total_labor_profit_money[$deptid],2)."', ".$total_labor_profit[$deptid]."],
                ]
            },";

        }

        //return dd($series);
        $this->data['departments']->series 		= $series;
        $this->data['departments']->drilldown 	= $drilldown;

		return View::make('admin.reports.index',$this->data);

	}


	public function overall()
	{

		$this->data['overallActive']    =   'active';

		$year	= (Input::get('year') != '') ? Input::get('year') : date('Y');

		$this->data['departments'] 		= 	Department::all();
		$this->data['projectexpenses']  =   Expense::all();
		$this->data['employees']  		=   Salary::lists('hour_rate','employeeID');

		
		foreach( $this->data['departments'] as $department ) {
				
				$deptname[$department->id] 		= 	"'".$department->deptName."'";
				$budget[$department->id] 		= 	$department->budget;
				$materials[$department->id] 	= 	$department->materials;
				$labor[$department->id] 		= 	$department->labor;
		}

		//expenses per month
		foreach( range(1,12) as $month ) {


			$depts[$month] = DB::select("select id, budget from department where month(created_at)=".$month);
			
			$budget_money[$month] = 0;
			foreach( $depts[$month] as $arr ) $budget_money[$month] += $arr->budget;

			if( $month > 1 ) $budget_money[$month] += $budget_money[$month-1];

			//print_r($budget_money);
		
			//expenses per project
			foreach( $this->data['departments'] as $department ) {

				$material_expenses	=	DB::select("select sum(price) as total from expenses where department=".$department->id." AND type <> '9' AND month(purchaseDate)=".$month);
				$mat_expenses 		= 	is_null($material_expenses[0]->total) ? '0' : $material_expenses[0]->total;

				$employees_rate	= 0;

				foreach( $this->data['employees'] as $employeeID => $hour_rate ) {
				
					$total				= 	DB::select("select sum(work_hours) as work_hours,sum(overtime) as overtime from attendance where department=".$department->id." AND employeeID=".$employeeID." AND month(date)=".$month);
					$total_work_hours	=	is_null($total[0]->work_hours) ? '0' : $total[0]->work_hours;
					$total_overtime		=	is_null($total[0]->overtime) ? '0' : $total[0]->overtime;
					$employees_rate		+= 	($total_work_hours + $total_overtime) * $hour_rate;
				}
				//monthly expenses = materials expenses - employees payslip
				$monthly_expenses[$month][$department->id] = $mat_expenses + $employees_rate;

				//projects' budget - expenses
				$budget[$department->id] -= $monthly_expenses[$month][$department->id];
			}

			$office_expenses	=	DB::select("select sum(price) as total from expenses where type = '9' AND month(purchaseDate)=".$month);
			$ofc_expenses 		= 	is_null($office_expenses[0]->total) ? '0' : $office_expenses[0]->total;


			$total_monthly_expenses[$month] = array_sum($monthly_expenses[$month]) + $ofc_expenses;

			$budget_money[$month] 			= $budget_money[$month] - $total_monthly_expenses[$month];

		}

	
        $this->data['profit'] = implode(",",$budget_money);

		return View::make('admin.reports.overall',$this->data);

	}



/*    Screen lock controller.When screen lock button from menu is cliked this controller is called.
*     lock variable is set to 1 when screen is locked.SET to 0  if you dont want screen variable
*/
	public function screenlock()
	{
		Session::put('lock', '1');		
		return View::make("admin/screen_lock",$this->data);
	}
}