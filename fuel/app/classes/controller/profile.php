<?php

/**
 * Auth Controller
 * 
 * @author Stefan Dyankov <s.dyankov@gmail.com>
 * @copyright (c) 2013
 */
class Controller_Profile extends \Controller_Base_User
{

    /**
     * The profile action for the application.
     *
     * @access  public
     * @return  Response
     */
    public function action_index()
    {
	list($driver, $user_id) = $this->auth_instance->get_user_id();
	
	$user = Model_User::find($user_id);
	
	$view = \Theme::instance()->view('profile/index');
	$view->set('user', $user);
	\Theme::instance()->set_partial('content', $view);
    }

}

/* EOF */