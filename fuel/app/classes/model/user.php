<?php

class Model_User extends \Orm\Model
{

    protected static $_properties = array(
	'id',
	'email',
	'username',
	'password',
	'group',
	'profile_fields',
	'login_hash',
	'last_login',
	'created_at',
	'updated_at',
    );
    protected static $_observers = array(
	'Orm\Observer_CreatedAt' => array(
	    'events' => array('before_insert'),
	    'mysql_timestamp' => true,
	),
	'Orm\Observer_UpdatedAt' => array(
	    'events' => array('before_update'),
	    'mysql_timestamp' => true,
	),
    );
    protected static $_table_name = 'users';
    protected static $_has_one = array(
	'profile',
	'userinvite',
    );
    protected static $_has_many = array(
	'invites',
    );

    public static function validate($factory)
    {
	$val = Validation::forge($factory);
	$val->add('username', 'Username')->add_rule('required');
	$val->add('password', 'Password');
		//->add_rule('valid_string', array('alpha', 'uppercase', 'lowercase', 'numeric', 'utf8'))
	$val->add('email', 'Email')->add_rule('required')->add_rule('valid_email');
	$val->add('group', 'Group')->add_rule('required');
	$val->add('full_name', 'Full Name')->add_rule('required');
	$val->add('phone', 'Phone');
	$val->add('website', 'Website');
	$val->add('active', 'Active');

	return $val;
    }

}
