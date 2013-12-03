<?php

use Orm\Model;

class Model_Stockgroup extends Model
{

    protected static $_properties = array(
	'id',
	'name',
    );
    protected static $_has_one = array(
	'stock',
    );

    public static function validate($factory)
    {
	$val = Validation::forge($factory);
	$val->add_field('name', 'Name', 'required|max_length[255]');

	return $val;
    }

}
