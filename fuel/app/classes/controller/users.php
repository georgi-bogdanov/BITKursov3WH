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

	$view = \Theme::instance()->view('admin/users');
	$view->set('users', $admins);
	$view->set('isAdmins', 1);
	\Theme::instance()->set_partial('content', $view);
    }

    public function action_edit($user_id = 0)
    {
	$user = NULL;


	//check if user is admin if not redirect him/her to the main site.
	if (!$this->auth_instance->member(50) && !$this->auth_instance->member(100))
	{
	    Response::redirect('home');
	}

	$this->_append_title('Create User');

	if ($user_id)
	{
	    $user = Model_User::find($user_id);
	    if (!$user)
	    {
		Session::set_flash('error', 'Invalid user.');
	    }
	}


	if (Input::method() == 'POST')
	{
	    $val = Model_User::validate('create');

	    if ($val->run())
	    {
		if (!isset($user) || !$user)
		{
		    $user = Model_User::forge(array(
			'username' => Input::post('username'),
			'email' => Input::post('email'),
			'group' => Input::post('group'),
			'password' => Input::post('password'),
		    ));
		}
		else
		{
		    $user->username = Input::post('username');
		    $user->email = Input::post('email');
		    $user->group = Input::post('group');
		}
		
		if ($user and $user->save())
		{
		    if(!$user_id)
		    {
			$profile = Model_Profile::forge(array(
			    'user_id' => $user->id,
			    'full_name' => Input::post('full_name'),
			    'phone' => Input::post('phone'),
			    'website' => Input::post('website'),
			    'active' => Input::post('active'),
			));
			$profile->save();
		    }
		    else
		    {
			$user->profile->full_name = Input::post('full_name');
			$user->profile->phone = Input::post('phone');
			$user->profile->website = Input::post('website');
			$user->profile->active = Input::post('active');
			$user->save();
		    }
		    
		    if(!$user_id)
		    {
			Session::set_flash('success', 'Added user #' . $user->id . '.');
		    }
		    else
		    {
			Session::set_flash('success', 'Edit user #' . $user->id . '.');
		    }
		    

		    Response::redirect('users/edit/' . $user->id);
		}
		else
		{
		    Session::set_flash('error', 'Could not save user.');
		}
	    }
	    else
	    {
		Session::set_flash('error', $val->error());
	    }
	}

	$view = \Theme::instance()->view('admin/edit');
	$view->set('user', $user, false);
	\Theme::instance()->set_partial('content', $view);
    }

    public function action_view($user_id)
    {
	$user = Model_User::find($user_id);

	if (!$user)
	{
	    Session::set_flash('error', 'There is no such user.');
	    Response::redirect('home');
	}

	$view = \Theme::instance()->view('admin/view');
	$view->set('user', $user);
	\Theme::instance()->set_partial('content', $view);
    }

}

/* EOF */