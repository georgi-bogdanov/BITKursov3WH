<?php

class Model_Language extends \Orm\Model
{

    protected static $_properties = array(
	'id',
	'name',
	'iso',
    );
    protected static $_table_name = 'languages';

}
