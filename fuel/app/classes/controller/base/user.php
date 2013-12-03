<?php

/**
 * Common Base Controller
 * 
 * @author Stefan Dyankov <s.dyankov@gmail.com>
 * @copyright (c) 2013
 */
class Controller_Base_User extends Controller_Base_Common
{

    public function before()
    {
        parent::before();

        //if user is not logged in redirect to login page
        if (!$this->is_logged) {
            Response::redirect('auth/login');
        }
    }

}

/* EOF */