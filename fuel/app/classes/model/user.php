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

}
