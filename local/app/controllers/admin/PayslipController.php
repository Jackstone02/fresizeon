<?php

class PayslipController extends \AdminBaseController {


    public function __construct()
    {
        parent::__construct();
        $this->data['payslipOpen'] ='active open';
        $this->data['pageTitle'] ='Payslip';
    }

    public function index()
    {
        $this->data['payslip']          =   Salary::all();
        $this->data['payslipActive']    =   'active';

        return View::make('admin.payslip.index', $this->data);
    }

    public function export()
    {
        //$input = Input::all();
        //return dd($input);
        $this->data['payslipActive']    =   'active';
        $this->data['payslip']      = Salary::all();
        $this->data['department']   = Department::lists('deptName','id');
        $this->data['payslip']->show = '';
        
        return View::make('admin.payslip.export', $this->data);
    }


    //Datatable ajax request
    public function ajax_payslip()
    {
        $result = Salary::select('id','employeeID','employeeName','department','daily_rate','hour_rate','overtime','days_work')
                        ->orderBy('created_at','desc');

        return Datatables::of($result)
            ->edit_column('department',function($row) {

                $project = Department::select('deptname')
                            ->where('id', '=', $row->department)
                            ->get();

                return $project[0]->deptname;
            })
            ->edit_column('daily_rate',function($row) { return number_format($row->daily_rate,2); })
            ->edit_column('hour_rate',function($row) { return number_format($row->hour_rate,2); })
            ->edit_column('Days Work',function($row) {

                //$days_work = Attendance::where('employeeID','=',$row->employeeID)->count();
                $days_work = count(DB::select( DB::raw("select * from attendance where employeeID = '". $row->employeeID  ."' AND status='present'")));
                $half_day = count(DB::select( DB::raw("select * from attendance where employeeID = '". $row->employeeID  ."' AND status='absent' AND leaveType='half day'")));

                $total_days_work = $days_work + $half_day;

                DB::table('salary')
                    ->where('employeeID',$row->employeeID )
                    ->update(array('days_work' => $total_days_work));

                return $total_days_work;
            })
            ->edit_column('salary',function($row){
                
                $days_work = $row->days_work;
                $overtime = DB::select("select sum(overtime) as total_time from attendance where employeeID = ". $row->employeeID ." AND status='present'");
                
                $salary_pay = ($row->daily_rate * $days_work) + ($row->hour_rate * $overtime[0]->total_time);

                DB::table('salary')
                    ->where('employeeID', $row->employeeID)
                    ->update(array('salary' => $salary_pay));

                return $salary_pay;
            })

            /*->add_column('edit', '
                        <a  class="btn purple"  href="{{ route(\'admin.payslip.edit\',$employeeID)}}" ><i class="fa fa-edit"></i> View</a>
                            &nbsp;<a href="javascript:;" onclick="del(\'{{ $id }}\',\'{{ $employeeID }}\');return false;" class="btn red">
                        <i class="fa fa-trash"></i> Delete</a>') */
            ->add_column('edit', '
                        <a  class="btn purple btn-circle"  href="{{ route(\'admin.payslip.edit\',$employeeID)}}" ><i class="fa fa-eye"></i> View</a>
                            &nbsp;')
            ->make();
    }

    public function exporting()
    {
        $this->data['payslipActive']    =   'active';

        $validator = Validator::make($input = Input::all(), Salary::$rules2);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        //$project = (Input::get('project') != '') ? Input::get('project') : '';
        $year    = (Input::get('year') != '') ? Input::get('year') : date('Y');
        $month   = (Input::get('month') != '') ? Input::get('month') : date('m');
        $pay     = (Input::get('pay') != '') ? Input::get('pay') : '1';

        $this->data['payslip']      = Salary::all();
        $this->data['department']   = Department::lists('deptName','id');
        //$this->data['employees']    = Employee::where('department', '=' ,$project)->get();
        $this->data['employees']    = Employee::get();
        $this->data['payslip']->show = 1;

        
        return View::make('admin.payslip.export', $this->data);
    }


    /**
     * Show the form for editing the specified payslip.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($employeeID)
    {
        //$this->data['payslip'] = Salary::find($id);
        $this->data['payslipActive']    =   'active';
        $this->data['payslip'] = Salary::where('employeeID', '=', $employeeID)->first();
        $new_arr = array();
        $this->data['payslip']->reason = $new_arr;
        
        return View::make('admin.payslip.edit', $this->data);
    }

    /**
     * Update the specified payslip in storage.
     *
     * @param  int  $id
     * @return Response
     */
    /*
    public function update($id)
    {
        $payslip = Salary::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Salary::$rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $payslip->update($data);

        Session::flash('success',"<strong>{$data['employeeName']}</strong> updated successfully");
        return Redirect::route('admin.payslip.edit',$id);
    }*/

    public function filter()
    {

        $this->data['payslipActive']    =   'active';
        $validator = Validator::make($input = Input::all(), Salary::$rules);
        //return dd($validator);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $employeeID = (Input::get('employeeID') != '') ? Input::get('employeeID') : '';
        $year       = (Input::get('year') != '') ? Input::get('year') : date('Y');
        $month      = (Input::get('month') != '') ? Input::get('month') : date('m');
        $pay        = (Input::get('pay') != '') ? Input::get('pay') : '1';

        $payperiod = ($pay == 1) ? "1 and 15" : "16 and 31";

        
        $days_work = count(DB::select("select * from attendance where employeeID = ". $employeeID ." AND status='present' AND year(date) = ". $year ." AND month(date) = ". $month ." AND (day(date) between ".$payperiod.")"));
        $undertime = DB::select("select * from attendance where employeeID = ". $employeeID ." AND status='present' AND work_hours < 8 AND year(date) = ". $year ." AND month(date) = ". $month ." AND (day(date) between ".$payperiod.")");

        $awards = DB::select("select sum(cashPrice) as total from awards where employeeID = ". $employeeID ." AND year(date) = ". $year ." AND month(date) = ". $month ." AND (day(date) between ".$payperiod.")");
        $awards_with_name = DB::select("select awardName, cashPrice from awards where employeeID = ". $employeeID ." AND year(date) = ". $year ." AND month(date) = ". $month ." AND (day(date) between ".$payperiod.")");

        $deductions = DB::select("select sum(amount) as total from deductions where employeeID = ". $employeeID ." AND year(date) = ". $year ." AND month(date) = ". $month ." AND (day(date) between ".$payperiod.")");
        $deductions_with_reasons = DB::select("select reason, amount from deductions where employeeID = ". $employeeID ." AND year(date) = ". $year ." AND month(date) = ". $month ." AND (day(date) between ".$payperiod.")");

        $overtime = DB::select("select sum(overtime) as total from attendance where employeeID = ". $employeeID ." AND status='present' AND year(date) = ". $year ." AND month(date) = ". $month ." AND (day(date) between ".$payperiod.")"); 

        $project = DB::select("select id,deptName from department");
        $projects_hours = DB::select("select department,sum(work_hours) as hours,sum(overtime) as othours from attendance where employeeID = ". $employeeID ." AND status='present' AND year(date) = ". $year ." AND month(date) = ". $month ." AND (day(date) between ".$payperiod.") group by department");


        $this->data['payslip'] = Salary::where('employeeID', '=', $employeeID)->first();

        $utime_total = 0;

        if( !empty($undertime) ) {
            foreach( $undertime as $time ) {
                $diff = 8 - $time->work_hours;
                $utime['reason'][] = "Undertime (".date('d/M/Y',strtotime($time->date)).") - ".$diff."hrs";
                $utime['amount'][] = $this->data['payslip']->hour_rate * $diff;
                $utime_total += ($this->data['payslip']->hour_rate * $diff);
            }
        }

        $awards_total       = (is_null($awards[0]->total))      ? '0' : $awards[0]->total;
        $deductions_total   = (is_null($deductions[0]->total))  ? '0' : $deductions[0]->total;
        $overtime_total     = (is_null($overtime[0]->total))    ? '0' : $overtime[0]->total;
        $proj_hrs           = (empty($projects_hours))          ? '0' : $projects_hours[0]->hours ;

        $this->data['payslip']->days_work   = $days_work;        
        $this->data['payslip']->awards      = $awards_total;
        $this->data['payslip']->deductions  = $deductions_total + $utime_total;
        $this->data['payslip']->overtime    = $overtime_total;
       


        //$this->data['payslip']->salary      = ($this->data['payslip']->daily_rate * $this->data['payslip']->days_work) + ($this->data['payslip']->hour_rate * $overtime[0]->total) + $this->data['payslip']->awards - $this->data['payslip']->deductions;
        $this->data['payslip']->salary      = ($this->data['payslip']->hour_rate * $proj_hrs) + ($this->data['payslip']->hour_rate * $overtime_total) + $this->data['payslip']->awards - $this->data['payslip']->deductions;
           
        $new_awardname = array();

        foreach( $awards_with_name as $rec ) {
            $new_awardname[] = "<div class='form-control'><table width='100%'><tr><td>".$rec->awardName."</td><td align='right'>".$rec->cashPrice."</td></tr></table></div>";
        }


        $new_reason = array();

        foreach( $deductions_with_reasons as $record ) {
            $new_reason[] = "<div class='form-control'><table width='100%'><tr><td>".$record->reason."</td><td align='right'>".$record->amount."</td></tr></table></div>";
        }

        if( !empty($utime) ) {
            foreach( range(0,count($utime['reason'])-1) as $i ) {
                $new_reason[] = "<div class='form-control'><table width='100%'><tr><td>".$utime['reason'][$i]."</td><td align='right'>".$utime['amount'][$i]."</td></tr></table></div>";
            }
        }

        $new_project_hours = array();
        foreach( $projects_hours as $phours ) {
            foreach( $project as $project_name){
                if( $project_name->id == $phours->department ){
                    $OT = ($phours->othours > 0 ) ? $phours->othours : "0";
                    $new_project_hours[] = "<div class='form-control'><table width='100%'><tr><td>".$project_name->deptName."</td><td align='right'> ".$phours->hours." hrs (".$OT." hrs OT)</td></tr></table></div>";
                }
            }
        }

        $this->data['payslip']->project_hours   = $new_project_hours;
        $this->data['payslip']->reason          = $new_reason;
        $this->data['payslip']->awardName       = $new_awardname;
        $this->data['payslip']->show            = 1;



        //return Redirect::back()->with('payslip', $month);
        return View::make('admin.payslip.edit', $this->data);
    }

    public function individualPay($employeeID,$year,$month,$pay){

        $payperiod = ($pay == 1) ? "1 and 15" : "16 and 31";
        $periodtext = ($pay == 1) ? "First half" : "Second half";
        $monthName = date('F', mktime(0, 0, 0, $month, 10));

        $employeeName = DB::select("select employeeName from salary where employeeID = ". $employeeID);
        $daily_rate = DB::select("select daily_rate from salary where employeeID = ". $employeeID);
        $hour_rate = DB::select("select hour_rate from salary where employeeID = ". $employeeID);
        $overtime_hours = DB::select("select sum(overtime) as total from attendance where employeeID = ". $employeeID ." AND status='present' AND year(date) = ". $year ." AND month(date) = ". $month ." AND (day(date) between ".$payperiod.")");
        $days_work = count(DB::select("select * from attendance where employeeID = ". $employeeID ." AND status='present' AND year(date) = ". $year ." AND month(date) = ". $month ." AND (day(date) between ".$payperiod.")"));
        $awards = DB::select("select sum(cashPrice) as total from awards where employeeID = ". $employeeID ." AND year(date) = ". $year ." AND month(date) = ". $month ." AND (day(date) between ".$payperiod.")");
        $awards_with_name = DB::select("select awardName,cashPrice from awards where employeeID = ". $employeeID ." AND year(date) = ". $year ." AND month(date) = ". $month ." AND (day(date) between ".$payperiod.")");
        $deductions = DB::select("select sum(amount) as total from deductions where employeeID = ". $employeeID ." AND year(date) = ". $year ." AND month(date) = ". $month ." AND (day(date) between ".$payperiod.")");
        $deductions_with_reasons = DB::select("select reason,amount from deductions where employeeID = ". $employeeID ." AND year(date) = ". $year ." AND month(date) = ". $month ." AND (day(date) between ".$payperiod.")");
        $project = DB::select("select id,deptName from department");
        $projects_hours = DB::select("select department,sum(work_hours) as hours,sum(overtime) as othours from attendance where employeeID = ". $employeeID ." AND status='present' AND year(date) = ". $year ." AND month(date) = ". $month ." AND (day(date) between ".$payperiod.") group by department");


        $new_awardname = array();
        foreach( $awards_with_name as $rec ) {
            $new_awardname[] = $rec->awardName." - ".$rec->cashPrice."<br/>";
        }
        

        $new_reason = array();
        foreach( $deductions_with_reasons as $record ) {
            $new_reason[] = $record->reason." - ".$record->amount."<br/>";
        }

        $new_project_hours = array();
        foreach( $projects_hours as $phours ) {
            foreach( $project as $project_name){
                if( $project_name->id == $phours->department ){
                $OT = ($phours->othours > 0 ) ? $phours->othours : "0";
                $new_project_hours[] = $project_name->deptName." = ".$phours->hours." hrs (".$OT." hrs OT)<br/>";
                }
            }
        }

        $awards_total       = (is_null($awards[0]->total))          ? '0' : $awards[0]->total;
        $deductions_total   = (is_null($deductions[0]->total))      ? '0' : $deductions[0]->total;
        $overtime_total     = (is_null($overtime_hours[0]->total))  ? '0' : $overtime_hours[0]->total;
        $proj_hrs           = (empty($projects_hours))              ? '0' : $projects_hours[0]->hours ;

  
        //$salary = $daily_rate[0]->daily_rate * $days_work;
        $salary = $proj_hrs * $hour_rate[0]->hour_rate;
        $total_overtime = $overtime_total * $hour_rate[0]->hour_rate;
        $totalsalary = $salary + $awards_total;
        $totaldeductions = $deductions_total; 

        $NET_PAY = $total_overtime + $totalsalary;
        $NET_PAY = $NET_PAY - $totaldeductions;

        $headers = array(
            "Content-type"=>"text/html",
            "Content-Disposition"=>"attachment;Filename=Payslip".time().".doc"
        );

        $content = "<html>
            <head>
            <meta charset='utf-8'>
            <style>
            body{
                font-family: Arial, Helvetica, sans-serif;
                font-size: 11px;
            }
            .secondpage{
                padding-left: 30px;
            }
            </style>
            </head>
            <body style='border:1px solid black'>
                <p>".$monthName." ".$year."<br/>".$periodtext." Payslip</p>
                <table class='payslip'>
                  <tr>
                    <td class='firstpage'>
                        <table>
                        <tr>
                            <td>Employee Name: </td><td>".$employeeName[0]->employeeName."</td>    
                        </tr>
                        <tr>
                            <td>Daily Rate: </td><td>".number_format($daily_rate[0]->daily_rate,2)."</td>    
                        </tr>
                        <tr>
                            <td>Hour Rate: </td><td>".number_format($hour_rate[0]->hour_rate,2)."</td>    
                        </tr>
                        <tr>
                            <td>OT Hours: </td><td>".$overtime_hours[0]->total."</td>    
                        </tr>
                        <tr>
                            <td>No. of days: </td><td>".$days_work."</td>    
                        </tr>
                        </table>
                    </td>
                    <td></td>
                    <td class='secondpage'>
                    <table>
                        <tr>
                            <td>Deductions: </td><td>";

                                foreach( $new_reason as $reason ) {
                                        $content .= $reason;
                                }

                            $content .= "</td>
                        </tr>
                        <tr>
                            <td>Awards/Bonus: </td><td>";
                                foreach( $new_awardname as $award ) {
                                        $content .= $award;
                                }

                            $content .= "</td>  
                        </tr>
                        <tr>
                            <td>Project Hours: </td><td>";
                                foreach( $new_project_hours as $p ) {
                                        $content .= $p;
                                }

                            $content .= "</td>    
                        </tr>
                        <tr>
                            <td></td><td></td>    
                        </tr>
                        <tr>
                            <td>Net Pay : Php </td><td>".number_format($NET_PAY,2)."</td>    
                        </tr>
                    </table>
                    </td>
                   </tr>
                </table>
            </body>
            </html>";

        return Response::make($content,200, $headers);


    } 

    public function exportPayslips(){

        //$IDs = (Input::get('employeeID') != '') ? Input::get('employeeID') : '';


        $year       = (Input::get('year2') != '') ? Input::get('year2') : date('Y');
        $month      = (Input::get('month2') != '') ? Input::get('month2') : date('m');
        $pay        = (Input::get('pay2') != '') ? Input::get('pay2') : '1';
        $payperiod = ($pay == 1) ? "1 and 15" : "16 and 31";
        $periodtext = ($pay == 1) ? "First half" : "Second half";
        $monthName = date('F', mktime(0, 0, 0, $month, 10));

        $employees = DB::select("select employeeID from employees");

        $employeeIDs=array();
        foreach ($employees as $IDs) {
            if(Input::get($IDs->employeeID) and (Input::get($IDs->employeeID)) == 'on' ){
                $employeeIDs[] = $IDs->employeeID;
            }
        }


        $headers = array(
            "Content-type"=>"text/html",
            "Content-Disposition"=>"attachment;Filename=Payslip".time().".doc"
        );

     
        $content = "<html>
                <head>
                <meta charset='utf-8'>
                <style>
                body{
                    font-family: Calibri, Helvetica, sans-serif;
                    font-size: 10px;
                }
                .secondpage{
                    padding-left: 30px;
                }
                </style>
                </head>
                <body>";
                   
        $ctr = 1;
        $content .="<table>";
        foreach($employeeIDs as $employeeID){  

            $employeeName = DB::select("select employeeName from salary where employeeID = ". $employeeID);
            $daily_rate = DB::select("select daily_rate from salary where employeeID = ". $employeeID);
            $hour_rate = DB::select("select hour_rate from salary where employeeID = ". $employeeID);
            $overtime_hours = DB::select("select sum(overtime) as total from attendance where employeeID = ". $employeeID ." AND status='present' AND year(date) = ". $year ." AND month(date) = ". $month ." AND (day(date) between ".$payperiod.")");
            $days_work = count(DB::select("select * from attendance where employeeID = ". $employeeID ." AND status='present' AND year(date) = ". $year ." AND month(date) = ". $month ." AND (day(date) between ".$payperiod.")"));
            $awards = DB::select("select sum(cashPrice) as total from awards where employeeID = ". $employeeID ." AND year(date) = ". $year ." AND month(date) = ". $month ." AND (day(date) between ".$payperiod.")");
            $awards_with_name = DB::select("select awardName,cashPrice from awards where employeeID = ". $employeeID ." AND year(date) = ". $year ." AND month(date) = ". $month ." AND (day(date) between ".$payperiod.")");
            $deductions = DB::select("select sum(amount) as total from deductions where employeeID = ". $employeeID ." AND year(date) = ". $year ." AND month(date) = ". $month ." AND (day(date) between ".$payperiod.")");
            $deductions_with_reasons = DB::select("select reason,amount from deductions where employeeID = ". $employeeID ." AND year(date) = ". $year ." AND month(date) = ". $month ." AND (day(date) between ".$payperiod.")");
            $project = DB::select("select id,deptName from department");
            $projects_hours = DB::select("select department,sum(work_hours) as hours,sum(overtime) as othours from attendance where employeeID = ". $employeeID ." AND status='present' AND year(date) = ". $year ." AND month(date) = ". $month ." AND (day(date) between ".$payperiod.") group by department");


            $new_awardname = array();
            foreach( $awards_with_name as $rec ) {
                $new_awardname[] = $rec->awardName." - ".$rec->cashPrice."<br/>";
            }
            

            $new_reason = array();
            foreach( $deductions_with_reasons as $record ) {
                $new_reason[] = $record->reason." - ".$record->amount."<br/>";
            }

            $new_project_hours = array();
            foreach( $projects_hours as $phours ) {
                    foreach( $project as $project_name){
                        if( $project_name->id == $phours->department ){
                        $OT = ($phours->othours > 0 ) ? $phours->othours : "0";
                        $new_project_hours[] = $project_name->deptName." = ".$phours->hours." hrs (".$OT." hrs OT)<br/>";
                        }
                    }
            }

            $awards_total       = (is_null($awards[0]->total))          ? '0' : $awards[0]->total;
            $deductions_total   = (is_null($deductions[0]->total))      ? '0' : $deductions[0]->total;
            $overtime_total     = (is_null($overtime_hours[0]->total))  ? '0' : $overtime_hours[0]->total;
            $proj_hrs           = (empty($projects_hours))              ? '0' : $projects_hours[0]->hours ;

      
            //$salary = $daily_rate[0]->daily_rate * $days_work;
            $salary = $proj_hrs * $hour_rate[0]->hour_rate;
            $total_overtime = $overtime_total * $hour_rate[0]->hour_rate;
            $totalsalary = $salary + $awards_total;
            $totaldeductions = $deductions_total; 

            $NET_PAY = $total_overtime + $totalsalary;
            $NET_PAY = $NET_PAY - $totaldeductions;

                if( $ctr % 3 == 1 ) $content .="<tr>";
                $content .="<td>";
                $content .="<div id='payslipcontent' style='border:1px solid black; width: 100%'>";
                $content .="<table class='payslip'>
                        <tr>
                            <td>
                                <p>".$monthName." ".$year."<br/>".$periodtext." Payslip</p>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class='firstpage'>
                                
                                <tr>
                                    <td>Name: </td><td>".$employeeName[0]->employeeName."</td>    
                                </tr>
                                <tr>
                                    <td>Daily Rate: </td><td>".number_format($daily_rate[0]->daily_rate,2)."</td>    
                                </tr>
                                <tr>
                                    <td>Hour Rate: </td><td>".number_format($hour_rate[0]->hour_rate,2)."</td>    
                                </tr>
                                <tr>
                                    <td>OT Hours: </td><td>".$overtime_hours[0]->total."</td>    
                                </tr>
                                <tr>
                                    <td>No. of days: </td><td>".$days_work."</td>    
                                </tr>
                                
                            </td>
                            <td></td>
                            <td class='secondpage'>
                                
                                    <tr>
                                        <td>Deductions: </td><td>";

                                            foreach( $new_reason as $reason ) {
                                                    $content .= $reason;
                                            }

                                        $content .= "</td>
                                    </tr>
                                    <tr>
                                        <td>Awards/Bonus: </td><td>";
                                            foreach( $new_awardname as $award ) {
                                                    $content .= $award;
                                            }

                                        $content .= "</td>  
                                    </tr>
                                    <tr>
                                        <td>Project Hours: </td><td>";
                                            foreach( $new_project_hours as $p ) {
                                                    $content .= $p;
                                            }

                                        $content .= "</td>    
                                    </tr>
                                    <tr>
                                        <td></td><td></td>    
                                    </tr>
                                    <tr>
                                        <td>Net Pay : Php </td><td>".number_format($NET_PAY,2)."</td>    
                                    </tr>
                                
                            </td>
                       </tr>
                    </table>";
                $content .="</div><hr>"; 
                $content .="</td>";
                if( $ctr % 3 == 0 ) $content .="</tr>";
                $ctr++;
        }
        $content .="</table>";
        $content .="</body>
                </html>";
                       


        //return dd($content);

        return Response::make($content,200, $headers);


    } 

    /**
     * Remove the specified payslip from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if (Request::ajax()) {

            Salary::destroy($id);
            $output['success'] = 'deleted';

            return Response::json($output, 200);
        }
    }


}
