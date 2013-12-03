<?php

class Controller_Admin extends \Controller_Base_Admin
{

    public function action_index()
    {
        //Page Title
        $this->_append_title('Admin Panel');
        $view = \Theme::instance()->view('admin/admin');
        \Theme::instance()->set_partial('content', $view);
    }

}

?>
