<?php

class ProjectExpensesController extends \AdminBaseController {



    public function __construct()
    {
        parent::__construct();
        $this->data['expensesOpen'] =	'active open';
        $this->data['pageTitle'] 	=	'Project Expenses';
    }

    public function index()
	{
		$this->data['projectexpenses']          =   Expense::all();
		$this->data['department']          		=   Department::lists('deptName','id');
        $this->data['projectexpensesActive']    =   'active';
        
        $this->data['projectexpenses']->show 	=  	'';
        $this->data['projectexpenses']->table 	= 	URL::route('admin.ajax_projectexpenses');
        $this->data['projectexpenses']->url 	= 	route('admin.projectexpenses.create');
        $this->data['projectexpenses']->dept    =   '';
        //return dd($this->data['projectexpenses']->url );


        $this->data['projectexpenses']->series = '';


		return View::make('admin.projectexpenses.index', $this->data);
	}

    public function filter()
	{

		$validator = Validator::make($input = Input::all(), Expense::$projectexpense_rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $department = (Input::get('department') != '') ? Input::get('department') : '';

		$this->data['projectexpenses']          =   Expense::all();
		$this->data['department']          		=   Department::lists('deptName','id');
        $this->data['projectexpensesActive']    =   'active';
        
        $this->data['projectexpenses']->table 	= 	URL::route('admin.ajax_projectexpenses','department='.$department);
        $this->data['projectexpenses']->url 	= 	route('admin.projectexpenses.create','department='.$department);
        $this->data['projectexpenses']->dept 	=   $this->data['department'][$department];
        //return dd($this->data['projectexpenses']->url );
        $this->data['projectexpenses']->show 	=  	1;


        $projectexpenses  = DB::select("select type,sum(price) as total from expenses where department='".$department."' group by 1");
        // echo "<pre>";
        // print_r($this->data['projectexpenses']);
        // echo "</pre>";

        $projectexpenses_naming = array(
            "1" => "Architectural/Civil",
            "2" => "Electrical",
            "3" => "Plumbing",
            "4" => "Mechanical",
            "5" => "Electronics (cctv/data/related works)"
        );

        foreach( range(1,5) as $i ) $type[$i] = 0;
        $series = "";
        $total = 0;

        foreach( $projectexpenses as $arr ) $total += $arr->total;       

        foreach( $projectexpenses as $arr ) {

            $type[$arr->type] = number_format($arr->total/$total,3);
        }
 

        $this->data['projectexpenses']->series = implode(",", $type);


		return View::make('admin.projectexpenses.index', $this->data);
	}


    //Datatable ajax request
    public function ajax_projectexpenses()
    {
        $result = Expense::
            select('id','type','itemName','department','purchaseDate','price')
            ->where('department', '=', Input::get('department'))
            ->orderBy('created_at','desc');

        return Datatables::of($result)
            ->edit_column('type',function($row){

                if( $row->type == 1 ) $type = 'Architectural/Civil';
                if( $row->type == 2 ) $type = 'Electrical';
                if( $row->type == 3 ) $type = 'Plumbing';
                if( $row->type == 4 ) $type = 'Mechanical';
                if( $row->type == 5 ) $type = 'Electronics (cctv/data/related works)';

                return $type;
            })
            ->edit_column('purchaseDate',function($row){
                return date('d-M-Y',strtotime($row->purchaseDate));
                //return Input::get('department');
            })
            ->edit_column('price',function($row){
                return number_format($row->price,2);
            })
            ->add_column('edit', '
                        <a  class="btn purple btn-circle"  href="{{ route(\'admin.projectexpenses.edit\',$id)}}" ><i class="fa fa-edit"></i> View/Edit</a>
                            &nbsp;<a href="javascript:;" onclick="del(\'{{ $id }}\',\'{{ $itemName }}\');return false;" class="btn red btn-circle">
                        <i class="fa fa-trash"></i> Delete</a>')
            ->make();
    }


	public function create()
	{
        $this->data['projectexpensesActive']    =   'active';
        $this->data['department']          	=   Department::lists('deptName','id');
        $this->data['dept'] 				=   $this->data['department'][Input::get('department')];
        $this->data['link'] 				= 	"http://localhost/fresizeon/admin/projectexpenses/project?department=".Input::get('department');
        //return dd($this->data['link']);

		return View::make('admin.projectexpenses.create',$this->data);
	}

	/**
	 * Store a newly created expense in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		$validator = Validator::make($input = Input::all(), Expense::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}


        $added_expenses_count = count($input["department"]);

        foreach( range(0,$added_expenses_count-1) as $i ) {
            unset($new_input);
            foreach( $input as $index => $value ) {

                if( $index == '_token' ) $new_input[$index] = $value;
                elseif( $index == 'purchaseDate' ) $new_input[$index]  =  date('Y-m-d',strtotime($value[$i]));
                else $new_input[$index] = $value[$i];
            }
            $expense =  Expense::create($new_input);
        }

        //$input['purchaseDate']   =   date('Y-m-d',strtotime( $input['purchaseDate']));
	    //$expense =	Expense::create($input);
        
        //----------------   Check if Bill is attached or not
        if (Input::hasFile('bill')) {

            $expense   = expense::find($expense->id);

            $path = public_path()."/expense/bills/";
            File::makeDirectory($path, $mode = 0777, true, true);

            $file 	= Input::file('bill');
            $extension      = $file->getClientOriginalExtension();
            $filename	= "bill-{$expense->slug}.$extension";
            Input::file('bill')->move($path, $filename);
            $expense->bill = $filename;

            $expense->save();

        }

        $text = $added_expenses_count > 1 ? 'items are' : 'item is';
		//return Redirect::route('admin.projectexpenses.index')->with('success',"<strong>{$input['itemName']}</strong> successfully added to the Database");
        //return Redirect::back()->with('success',"<strong>{$input['itemName']}</strong> successfully added to the Database");
        return Redirect::back()->with('success',"<strong>$added_expenses_count</strong> $text successfully added to the Database");
	}



	/**
	 * Show the form for editing the specified expense.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$this->data['projectexpensesActive']    =   'active';
        $this->data['expense'] = Expense::find($id);
        $this->data['link']    =   "http://localhost/fresizeon/admin/projectexpenses/project?department=".$this->data['expense']->department;

		return View::make('admin.projectexpenses.edit', $this->data);
	}

	/**
	 * Update the specified expense in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$expense = Expense::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Expense::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

        $data['purchaseDate']   =   date('Y-m-d',strtotime( $data['purchaseDate']));


        if (Input::hasFile('bill')) {

            $path = public_path()."/expense/bills/";
            File::makeDirectory($path, $mode = 0777, true, true);

            $file 	= Input::file('bill');
            $extension      = $file->getClientOriginalExtension();
            $filename	= "bill-{$expense->slug}.$extension";

            Input::file('bill')->move($path, $filename);
            $data['bill'] = $filename;

        }else{
            $data['bill'] = $data['billhidden'];
        }
            unset($data['billhidden']);
		$expense->update($data);

        Session::flash('success',"<strong>{$data['itemName']}</strong> updated successfully");
		return Redirect::route('admin.projectexpenses.edit',$id);
	}

	/**
	 * Remove the specified expense from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if (Request::ajax()) {

			Expense::destroy($id);
			$output['success'] = 'deleted';

			return Response::json($output, 200);
		}
	}

}
