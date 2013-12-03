<?php

/**
 * Home Controller
 * 
 * @author Stefan Dyankov <s.dyankov@gmail.com>
 * @copyright (c) 2013
 */
class Controller_Home extends \Controller_Base_User
{

    public function action_index()
    {
	$view = \Theme::instance()->view('home/index');

	\Theme::instance()->set_partial('content', $view);
    }

}

/* EOF */