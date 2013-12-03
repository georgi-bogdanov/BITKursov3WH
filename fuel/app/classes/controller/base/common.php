<?php

/**
 * Common Base Controller
 * 
 * @author Stefan Dyankov <s.dyankov@gmail.com>
 * @copyright (c) 2013
 */
class Controller_Base_Common extends Controller_Hybrid
{

    //set template name.
    public $template = 'templates/layout';
    //Meta tags
    private $meta = array();
    //Page Title
    private $title = '';
    private $page_title = '';

    //Inline Scripting
    public function before()
    {
        //get the auth instance (allow us to use verify_multiple_logins)
        $this->auth_instance = Auth::instance();

        // Assign auth and is_logged variabls to the instance so controllers can use it
        $this->is_logged = $this->auth_instance->check();

        //set the theme
        \Theme::instance()->set_template($this->template);

        // Set a global variabls so views can use it
        \Theme::instance()->get_template()->set_global('is_logged', $this->is_logged);
        \Theme::instance()->get_template()->set_global('auth_instance', $this->auth_instance, false);

        //set the defualt title
        $this->title = Config::get('site_name');
    }

    /**
     * Adds meta tags.
     *
     * @access protected
     * @param string $name the name of the meta tag
     * @param string $content the content of the mneta tag
     * @return bool
     */
    public function _add_meta($name, $content)
    {
        if (array_key_exists($name, $this->meta)) {
            die("Duplicate usage of meta tag file <tt>$name</tt>.");
        }

        $this->meta[$name] = $content;
        return true;
    }

    /**
     * Sets the page title
     *
     * @access public
     * @param string $new_title
     * @return void
     */
    public function _set_title($new_title)
    {
        $this->title = $new_title;
    }

    /**
     * Appends a string at the title text
     *
     * @access public
     * @param string $title
     * @return void
     */
    public function _append_title($title)
    {
        $this->page_title = $title;
        $this->title = "$title | " . $this->title;
    }

    /**
     * After controller method has run, render the theme template
     *
     * @param  Response  $response
     */
    public function after($response)
    {
        //Set the page title.
        \Theme::instance()->get_template()->set_global('title', $this->title);
        \Theme::instance()->get_template()->set_global('page_title', $this->page_title);
        \Theme::instance()->get_template()->set_global('meta', $this->meta);

        // If no response object was returned by the action,
        if (empty($response) or !$response instanceof Response) {
            // render the defined template
            $response = \Response::forge(\Theme::instance()->render());
        }

        return parent::after($response);
    }

}
