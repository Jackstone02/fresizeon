<?php

class Salary extends \Eloquent {

	protected $table ='salary';
	
	public static $rules = [
		//'type'   =>  'required',
		//'salary' =>  'required'
		'year' => 'required',
		'month' => 'required',
		'pay' => 'required'
	];

	public static $rules2 = [
		//'type'   =>  'required',
		//'salary' =>  'required'
		//'project' => 'required',
		'year' => 'required',
		'month' => 'required',
		'pay' => 'required'
	];

	public static $rules3 = [
		'department' => 'required'
	];
	
	protected $fillable = [];
    
    protected $guarded = ['id'];
}