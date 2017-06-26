<?php

class OvertimeController extends \AdminBaseController {


    public function __construct()
    {
        parent::__construct();
        $this->data['payslipOpen'] ='active open';
        $this->data['pageTitle']  =  'Overtime';
    }

    //    Display a listing of overtime
    public function index()
	{
		$this->data['overtime'] = Overtime::all();

        $this->data['overtimeActive'] =   'active';

		return View::make('admin.overtime.index', $this->data);
	}


    //Datatable ajax request
    public function ajax_overtime()
    {

	    $result = Overtime::select('overtime.id','overtime.employeeID','fullName','time','reason','date')
		      	->join('employees', 'overtime.employeeID', '=', 'employees.employeeID')
			  	->orderBy('overtime.created_at','desc');

        return Datatables::of($result)

			->edit_column('date', function($row) {
				return date('d-M-Y',strtotime($row->date));
			})
            ->add_column('edit', '
                        <a  class="btn purple"  href="{{ route(\'admin.overtime.edit\',$id)}}" ><i class="fa fa-edit"></i> View/Edit</a>
                            &nbsp;<a href="javascript:;" onclick="del(\'{{ $id }}\',\'{{ $fullName}}\');return false;" class="btn red">
                        <i class="fa fa-trash"></i> Delete</a>')
            ->make();
    }

	public function create()
	{
        $this->data['addovertimeActive'] = 'active';
        $this->data['employees'] = Employee::selectRaw('CONCAT(fullName, " (EmpID:", employeeID,")") as full_name, employeeID')
	                                        ->where('status','=','active')
	                                        ->lists('full_name','employeeID');

		return View::make('admin.overtime.create',$this->data);
	}

	/**
	 * Store a newly created Overtime in storage.
	 */

	public function store()
	{

		$validator = Validator::make($input = Input::all(), Overtime::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$employee = Employee::select('email','fullName')->where('employeeID', '=', $input['employeeID'])->first();

	    $this->data['employee_name'] = $employee->fullName;

		Overtime::create($input);

		return Redirect::route('admin.overtime.index')->with('success',"Overtime created for <strong>{$employee->fullName}</strong>");
	}



	/**
	 * Show the form for editing the specified Overtime.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

        $this->data['overtime'] = Overtime::find($id);
        $this->data['addOvertimeActive'] = 'active';
        $this->data['employees'] = Employee::lists('fullName','employeeID');
		return View::make('admin.overtime.edit', $this->data);
	}

	/**
	 * Update the specified Overtime in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$Overtime = Overtime::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Overtime::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$Overtime->update($data);

		return Redirect::route('admin.overtime.edit',$id)->with('success',"<strong>Success</strong> Updated Successfully");
	}

	/**
	 * Remove the specified Overtime from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if (Request::ajax()) {
			Overtime::destroy($id);
			$output['success'] = 'deleted';

			return Response::json($output, 200);
		}else{
			throw(new Exception('Wrong request'));
		}

	}

}
