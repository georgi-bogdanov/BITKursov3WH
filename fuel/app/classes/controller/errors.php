<?php

/**
 * Home Controller
 * 
 * @author Stefan Dyankov <s.dyankov@gmail.com>
 * @copyright (c) 2013
 */
class Controller_Errors extends \Controller_Base_Common
{
    /**
     * The 404 action for the application.
     *
     * @access  public
     * @return  Response
     */
    public function action_404()
    {
        $this->_append_title('Not Found');
        \Theme::instance()->set_partial('content', 'errors/404');
    }
}

/* EOF */