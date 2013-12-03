<?php

/**
 * Auth Controller
 * 
 * @author Stefan Dyankov <s.dyankov@gmail.com>
 * @copyright (c) 2013
 */
class Controller_Auth extends \Controller_Base_Public
{

    public static function _init()
    {
	\Theme::instance()->asset->css('auth.css', array(), 'header');
    }

    /**
     * The login.
     *
     * @access  public
     * @return  Response
     */
    public function action_login()
    {
	$this->_append_title('Login');
	$auth = \Auth::instance();

	if (\Input::post())
	{
	    if ($auth->login(\Input::param('username'), \Input::param('password')))
	    {
		\Session::set_flash('success', 'Successfully logged in! Welcome ' . $auth->get_screen_name());
		\Response::redirect('/');
	    }
	    else
	    {
		\Session::set_flash('error', 'Username or password incorrect.');
		\Response::redirect('auth/login');
	    }
	}

	\Theme::instance()->set_partial('content', 'auth/login');
    }

    /**
     * The Register.
     *
     * @access  public
     * @return  Response
     */
    public function action_register()
    {
	$this->_append_title('Register');
	$view = \Theme::instance()->view('auth/register');


	/* If it's an invite */
	$ref = $this->param('ref') ? $this->param('ref') : '';
	$ref_id = 0;
	$invite = null;
	if ($ref)
	{
	    $invite = Model_Invite::find('first', array('where' => array('code' => $ref)));

	    if ($invite)
	    {

		$ref = Model_User::find($invite->user_id);

		if ($ref)
		{
		    $ref_id = $ref->id;
		    $view->set('invited_email', $invite->to);
		}
	    }
	}
	/* End of invite section */

	//form data
	$data = array('username' => '', 'email' => '', 'password' => '', 'agree' => '');

	/* Validation */
	$val = \Myvalidation::forge('register');
	$val->add_field('username', 'Username', 'required|unique[users.username]')
		->add_rule('valid_string', array('alpha', 'numeric', 'dashes', 'utf8'));
	$val->set_message('valid_string', 'The field :label must contain only latin letters, numbers and dashes');
	$val->add_field('email', 'Email', 'required|valid_email|unique[users.email]');
	$val->add_field('password', 'Password', 'required|min_length[7]');
	$val->add_field('agree', 'Terms of Service', 'required');
	/* End of validation */

	$response = null;
	/* Actual Registration */
	if (\Input::post())
	{
	    if ($val->run())
	    {
		if ($invite)
		{
		    $email = $invite->to;
		}
		else
		{
		    $email = $val->validated('email');
		}

		try
		{
		    $user_id = \Auth::instance()->create_user($val->validated('username'), $val->validated('password'), $email);
		}
		catch (\Auth\SimpleUserUpdateException $e)
		{
		    //show the create user auth error
		    $response .= $e->getMessage();
		}

		if ($user_id)
		{

		    $code = \Str::random('unique');

		    if ($invite)
		    {
			$invite->code = NULL;
			$invite->save();
		    }

		    $profile = Model_Profile::forge(array(
				'user_id' => $user_id,
				'activation_code' => $code,
				'active' => 0,
				'ref_id' => 0,
		    ));
		    $profile->save();

		    /*
		      //set user welcome email
		      \Package::load('email');
		      $email = \Email::forge();
		      $email->from(\Config::get('email'), \Config::get('email_name'));
		      $email->to($val->validated('email'), $val->validated('username'));
		      $email->subject('Successful user registration on ' . \Config::get('site_name'));
		      $email_data = array('username' => $val->validated('username'), 'password' => $val->validated('password'), 'code' => $code, 'site_name' => \Config::get('site_name'));
		      $email->html_body(\View::forge('auth/emails/register', $email_data));
		      $email->send();
		     */

		    //login the user and redirect
		    \Auth::instance()->force_login($user_id);
		    \Session::set_flash('success', 'You have logged in with your new account.');
		    \Response::redirect();
		}
	    }
	    else
	    {
		foreach ($val->error() as $e)
		{
		    //show the validation errors
		    $response .= '<p class="alert alert-danger alert-dismissable">' . $e->get_message() . '</p>';
		}
	    }

	    //repopulate the form
	    $data = $val->input();
	    $data['agree'] = $val->input('agree') ? 'checked="checked"' : '';
	}
	/* End of Registration */


	$view->set('response', $response, false);
	$view->set('data', $data, false);
	\Theme::instance()->set_partial('content', $view);
    }

    /**
     * The Reser Password.
     *
     * @access  public
     * @return  Response
     */
    public function action_resetpassword()
    {
	$this->_append_title('Register');
	\Theme::instance()->set_partial('content', 'auth/resetpassword');
    }

}

/* EOF */