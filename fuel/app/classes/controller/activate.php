<?php

/**
 * Auth Controller
 * 
 * @author Stefan Dyankov <s.dyankov@gmail.com>
 * @copyright (c) 2013
 */
class Controller_Activate extends \Controller_Base_Common
{

    public function action_index($code = null)
    {
        is_null($code) && \Fuel\Core\Response::redirect('home');

        $profile = Model_Profile::find('first', array('where' => array('activation_code' => $code)));

        if (!$profile) {
            \Session::set_flash('error', 'Invalid or already used activation code.');
            \Response::redirect('home');
        } elseif ($profile->active == 1) {
            $profile->activation_code = null;
            $profile->save();
            \Session::set_flash('error', 'Your account is already activated.');
            \Response::redirect('home');
        } else {
            $profile->activation_code = null;
            $profile->active = 1;
            $profile->save();
            \Session::set_flash('success', 'Your account is activated.');
            \Response::redirect('home');
        }

        $this->_append_title('User Account Activation');
    }

}

/* EOF */