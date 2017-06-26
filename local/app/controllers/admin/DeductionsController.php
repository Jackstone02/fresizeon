<?php

class DeductionsController extends \AdminBaseController {


    public function __construct()
    {
        parent::__construct();
        $this->data['awardsOpen'] ='active open';
        $this->data['pageTitle']  =  'Deductions';
    }

    //    Display a listing of deductions
    public function index()
	{
		$this->data['deductions'] = Deductions::all();

        $this->data['deductionsActive'] =   'active';

		return View::make('admin.deductions.index', $this->data);
	}


    //Datatable ajax request
    public function ajax_deductions()
    {
	    $result =
		    Deductions::select('deductions.id','deductions.employeeID','fullName','reason','amount','date')
		      ->join('employees', 'deductions.employeeID', '=', 'employees.employeeID')
			  ->orderBy('deductions.created_at','desc');
		
        return Datatables::of($result)
            ->edit_column('date', function($row) {
				return date('d-M-Y',strtotime($row->date));
			})
            ->add_column('edit', '
                        <a  class="btn purple btn-circle"  href="{{ route(\'admin.deductions.edit\',$id)}}" ><i class="fa fa-edit"></i> View/Edit</a>
                            &nbsp;<a href="javascript:;" onclick="del(\'{{ $id }}\',\'{{ $fullName}}\');return false;" class="btn red btn-circle">
                        <i class="fa fa-trash"></i> Delete</a>')
            ->make();
    }

	public function create()
	{
        $this->data['deductionsActive'] =   'active';
        $this->data['employees'] = Employee::selectRaw('CONCAT(fullName, " (EmpID:", employeeID,")") as full_name, employeeID')
	                                        ->where('status','=','active')
	                                        ->lists('full_name','employeeID');

		return View::make('admin.deductions.create',$this->data);
	}

	/**
	 * Store a newly created deductions in storage.
	 */

	public function store()
	{

		$validator = Validator::make($input = Input::all(), Deductions::$rules);

		$employee = Employee::select('email','fullName')->where('employeeID', '=', $input['employeeID'])->first();

	    $this->data['employee_name'] = $employee->fullName;

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Deductions::create($input);

		return Redirect::route('admin.deductions.index')->with('success',"<strong>{$employee->fullName}</strong> is given deduction");
	}

	/**
	 * Show the form for editing the specified Deductions.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

        $this->data['deductions']    = Deductions::find($id);
        $this->data['deductionsActive'] =   'active';
        $this->data['employees'] = Employee::lists('fullName','employeeID');
		return View::make('admin.deductions.edit', $this->data);
	}

	/**
	 * Update the specified deductions in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$deductions = Deductions::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Deductions::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$deductions->update($data);

		return Redirect::route('admin.deductions.edit',$id)->with('success',"<strong>Success</strong> Updated Successfully");
	}

	/**
	 * Remove the specified deductions from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if (Request::ajax()) {
			Deductions::destroy($id);
			$output['success'] = 'deleted';

			return Response::json($output, 200);
		}else{
			throw(new Exception('Wrong request'));
		}

	}

}
