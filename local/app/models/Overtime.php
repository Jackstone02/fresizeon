<?php

class Overtime extends \Eloquent {

 	protected $table = 'overtime';
 	
	// Add your validation rules here
	public static $rules = [
        'employeeID'     =>  'required',
	];

	// Don't forget to fill this array
    protected $guarded = ['id'];

    public function employeeDetails(){

        return $this->belongsTo('Employee','employeeID','employeeID');
    }

}