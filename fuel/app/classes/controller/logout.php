<?php

/**
 * Auth Controller
 * 
 * @author Stefan Dyankov <s.dyankov@gmail.com>
 * @copyright (c) 2013
 */
class Controller_Logout extends \Controller_Base_Common
{

    public function action_index()
    {
	$auth = \Auth::instance();
	$auth->logout();
	\Response::redirect('/');
    }

}

/* EOF */