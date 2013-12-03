<?php

/**
 * Admin Base Controller
 * 
 * @author Stefan Dyankov <s.dyankov@gmail.com>
 * @copyright (c) 2013
 */
class Controller_Base_Admin extends Controller_Base_Common
{

    public $template = 'templates/layout';

    public function before()
    {
	parent::before();
	//if user is not logged in redirect to login page
	if (!$this->is_logged)
	{
	    Response::redirect('home');
	}

	//check if user is admin if not redirect him/her to the main site.
	if (!$this->auth_instance->member(100))
	{
	    Response::redirect('home');
	}
    }

}

/* EOF */