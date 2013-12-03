<?php

/**
 * Stocks Controller
 * 
 * @author Stefan Dyankov <s.dyankov@gmail.com>
 * @copyright (c) 2013
 */
class Controller_Users extends \Controller_Base_Admin
{

    /**
     * The Users action for the application.
     *
     * @access  public
     * @return  Response
     */
    public function action_index()
    {
	$this->_append_title('Users');
	$users = Model_User::query()->where('group', '<=', '50')->get();
	
	$view = \Theme::instance()->view('admin/users');
	$view->set('users', $users);
	\Theme::instance()->set_partial('content', $view);
    }
    
    /**
     * The Admin action for the application.
     *
     * @access  public
     * @return  Response
     */
    public function action_admins()
    {
	$this->_append_title('Users');
	$admins = Model_User::query()->where('group', '>', '50')->get();
	
	$view = \Theme::instance()->view('admin/admins');
	$view->set('admins', $admins);
	\Theme::instance()->set_partial('content', $view);
    }

}

/* EOF */