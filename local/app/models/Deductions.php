<?php

class Deductions extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
        'employeeID'    =>  'required',
        'reason'     	=>  'required',
        'amount'     	=>  'required',
        'date'     		=>  'required'
	];

	// Don't forget to fill this array
    protected $guarded = ['id'];

    public function employeeDetails(){

        return $this->belongsTo('Employee','employeeID','employeeID');
    }

}