<?php

class Model_Userinvite extends \Orm\Model
{

    protected static $_properties = array(
	'id',
	'user_id',
	'count',
	'unlimited',
	'can_invite',
    );
    protected static $_table_name = 'userinvites';
    protected static $_belongs_to = array('user');

}
