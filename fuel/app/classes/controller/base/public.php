<?php

/**
 * Common Base Controller
 * 
 * @author Stefan Dyankov <s.dyankov@gmail.com>
 * @copyright (c) 2013
 */
class Controller_Base_Public extends Controller_Base_Common
{
    public function before()
    {
        parent::before();
        
        //if user is logged redirect to home.
        if ($this->is_logged) {
            Response::redirect('/home');
        }
    }
}

/* EOF */