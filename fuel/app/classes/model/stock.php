<?php

class Model_Stock extends \Orm\Model
{

    protected static $_properties = array(
	'id',
	'user_id',
	'stockgroup_id',
	'name',
	'qty',
	'description',
    );
    protected static $_table_name = 'stocks';
    protected static $_belongs_to = array('stockgroup');


    public static function validate($factory)
    {
	$val = Validation::forge($factory);
	$val->add_field('name', 'Name', 'required|max_length[255]');
	$val->add_field('qty', 'Qty', 'required|valid_string[integer]');
	$val->add_field('description', 'Description', 'required');
	$val->add_field('stockgroup_id', 'Stockgroup', 'required|valid_string[integer]');

	return $val;
    }

}
