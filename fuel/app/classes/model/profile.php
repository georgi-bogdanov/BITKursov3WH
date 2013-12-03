<?php

class Model_Profile extends \Orm\Model
{

    protected static $_properties = array(
	'id',
	'user_id',
	'full_name',
	'info',
	'ref_id',
	'country_id',
	'language_id',
	'phone',
	'website',
	'logo',
	'cover',
	'activation_code',
	'active',
    );
    protected static $_table_name = 'profiles';
    protected static $_belongs_to = array('user', 'country', 'language');

}
