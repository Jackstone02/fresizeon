<?php

class ExpensesController extends \AdminBaseController {



    public function __construct()
    {
        parent::__construct();
        $this->data['expensesOpen'] =	'active open';
        $this->data['pageTitle'] 	=	'Office Expenses';
    }

    public function index()
	{
		Input::replace(['year' => date('Y') , 'month' => date('m')]);

		$this->data['expenses']          =   Expense::all();
        $this->data['expensesActive']    =   'active';

        $this->data['expenses']->show 	=  	'';
        $this->data['expenses']->table 	= 	URL::route('admin.ajax_expenses','year='.date("Y").'&month='.date("m"));
        $this->data['expenses']->url 	= 	route('admin.expenses.create');
        

        $expense = DB::select( DB::raw("SELECT sum(price) as sum,m.month
     	FROM (
           SELECT 1 AS MONTH
           UNION SELECT 2 AS MONTH
           UNION SELECT 3 AS MONTH
           UNION SELECT 4 AS MONTH
           UNION SELECT 5 AS MONTH
           UNION SELECT 6 AS MONTH
           UNION SELECT 7 AS MONTH
           UNION SELECT 8 AS MONTH
           UNION SELECT 9 AS MONTH
           UNION SELECT 10 AS MONTH
           UNION SELECT 11 AS MONTH
           UNION SELECT 12 AS MONTH
          ) AS m
		LEFT JOIN `expenses` u
		ON m.month = MONTH(purchaseDate)
   		AND YEAR(purchaseDate) = ".date("Y")."
   		AND TYPE='9'

		GROUP BY m.month
		ORDER BY month ;"));


		foreach($expense as $ex){
			$expensevalue[] = isset($ex->sum)?$ex->sum:"''";
		}
		$this->data['expenses']->chart = implode(',',$expensevalue);

		return View::make('admin.expenses.index', $this->data);
	}

	public function filter()
	{

		$validator = Validator::make($input = Input::all(), Expense::$expense_rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $input = Input::all();
        $year = (Input::get('year') != '') ? Input::get('year') : '';
        $month = (Input::get('month') != '') ? Input::get('month') : '';

		$this->data['expenses']          =   Expense::all();
        $this->data['expensesActive']    =   'active';

        $this->data['expenses']->table 	= 	URL::route('admin.ajax_expenses','year='.$year.'&month='.$month);
        $this->data['expenses']->url 	= 	route('admin.expenses.create');
        $this->data['expenses']->show 	=  	1;

        $expense = DB::select( DB::raw("SELECT sum(price) as sum,m.month
     	FROM (
           SELECT 1 AS MONTH
           UNION SELECT 2 AS MONTH
           UNION SELECT 3 AS MONTH
           UNION SELECT 4 AS MONTH
           UNION SELECT 5 AS MONTH
           UNION SELECT 6 AS MONTH
           UNION SELECT 7 AS MONTH
           UNION SELECT 8 AS MONTH
           UNION SELECT 9 AS MONTH
           UNION SELECT 10 AS MONTH
           UNION SELECT 11 AS MONTH
           UNION SELECT 12 AS MONTH
          ) AS m
		LEFT JOIN `expenses` u
		ON m.month = MONTH(purchaseDate)
   		AND YEAR(purchaseDate) = ".$year."
   		AND TYPE='9'

		GROUP BY m.month
		ORDER BY month ;"));


		foreach($expense as $ex){
			$expensevalue[] = isset($ex->sum)?$ex->sum:"''";
		}
		$this->data['expenses']->chart = implode(',',$expensevalue);


		return View::make('admin.expenses.index', $this->data);
	}

    //Datatable ajax request
    public function ajax_expenses()
    {

        $result = Expense::
            select('id','itemName','purchaseDate','price')
            ->where('type', '=', '9')
            ->whereMonth('purchaseDate', '=', Input::get('month'))
            ->whereYear('purchaseDate', '=', Input::get('year'))
            ->orderBy('created_at','desc');


        return Datatables::of($result)
            ->edit_column('purchaseDate',function($row){
                return date('d-M-Y',strtotime($row->purchaseDate));
            })
            ->edit_column('price',function($row){
                return number_format($row->price,2);
            })
            ->add_column('edit', '
                        <a  class="btn purple btn-circle"  href="{{ route(\'admin.expenses.edit\',$id)}}" >
                        	<i class="fa fa-edit"></i> View/Edit
                        </a>
                            &nbsp;
                        <a href="javascript:;" onclick="del(\'{{ $id }}\',\'{{ $itemName }}\');return false;" class="btn red btn-circle">
                        	<i class="fa fa-trash"></i> Delete
                        </a>')
            ->make();
    }


	public function create()
	{
        $this->data['expensesActive']    =   'active';

		return View::make('admin.expenses.create',$this->data);
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
        //----------------   Check if Bill is attached or not

		$added_expenses_count = count($input["department"]);


        foreach( range(0,$added_expenses_count-1) as $i ) {
            unset($new_input);
            foreach( $input as $index => $value ) {

                if( $index == '_token' ) $new_input[$index] = $value;
                elseif( $index == 'purchaseDate' ) $new_input[$index]  =  date('Y-m-d',strtotime($value[$i]));
                elseif( $index == 'type' ) $new_input[$index]  =  '9';
                else $new_input[$index] = $value[$i];
            }
            $expense =  Expense::create($new_input);
        }


        //$input['purchaseDate']   =   date('Y-m-d',strtotime( $input['purchaseDate']));
	    //$expense =	Expense::create($input);

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
		//return Redirect::route('admin.expenses.index')->with('success',"<strong>{$input['itemName']}</strong> successfully added to the Database");;
		//return Redirect::route('admin.expenses.index')->with('success',"<strong>$added_expenses_count</strong> $text successfully added to the Database");
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
		$this->data['expensesActive']    =   'active';
		$this->data['expense'] = Expense::find($id);

		return View::make('admin.expenses.edit', $this->data);
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
		return Redirect::route('admin.expenses.edit',$id);
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
