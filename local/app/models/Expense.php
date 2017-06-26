<?php
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
class Expense extends \Eloquent implements SluggableInterface {

    use SluggableTrait;

    protected $sluggable = array(
        'build_from' => 'itemName',
        'save_to'    => 'slug',
    );

	// Add your validation rules here
	public static $rules = [
		 //'department' => 'required',
		'itemName' => 'required',
		'price' => 'required'
	];

	public static $projectexpense_rules = [
		 //'department' => 'required',
		'department' => 'required',
	];

	public static $expense_rules = [
		 //'department' => 'required',
		'year' => 'required',
		'month' => 'required'
	];



	// Don't forget to fill this array
	protected $fillable = [];

    protected $guarded  =   ['id'];

}