<?php

class Controller_Stockgroups extends Controller_Base_Admin
{

    public function action_index()
    {
	$this->_append_title('Stock Groups');
	
	$data['stockgroups'] = Model_Stockgroup::find('all');
	$view = \Theme::instance()->view('stockgroups/index', $data);
	\Theme::instance()->set_partial('content', $view);
    }

    public function action_view($id = null)
    {
	is_null($id) and Response::redirect('stock groups');

	$this->_append_title('View Stock Group');
	
	if (!$data['stockgroup'] = Model_Stockgroup::find($id))
	{
	    Session::set_flash('error', 'Could not find stock group #' . $id);
	    Response::redirect('stockgroups');
	}

	$view = \Theme::instance()->view('stockgroups/view', $data);
	\Theme::instance()->set_partial('content', $view);
    }

    public function action_create()
    {
	$this->_append_title('Create Stock Group');
	
	if (Input::method() == 'POST')
	{
	    $val = Model_Stockgroup::validate('create');

	    if ($val->run())
	    {
		$stockgroup = Model_Stockgroup::forge(array(
			    'name' => Input::post('name'),
		));

		if ($stockgroup and $stockgroup->save())
		{
		    Session::set_flash('success', 'Added stockgroup #' . $stockgroup->id . '.');

		    Response::redirect('stockgroups');
		}
		else
		{
		    Session::set_flash('error', 'Could not save stock group.');
		}
	    }
	    else
	    {
		Session::set_flash('error', $val->error());
	    }
	}

	$view = \Theme::instance()->view('stockgroups/create');
	\Theme::instance()->set_partial('content', $view);
    }

    public function action_edit($id = null)
    {
	is_null($id) and Response::redirect('stockgroups');

	if (!$stockgroup = Model_Stockgroup::find($id))
	{
	    Session::set_flash('error', 'Could not find stock group #' . $id);
	    Response::redirect('stockgroups');
	}

	$this->_append_title('Edit Stock Group');
	$view = \Theme::instance()->view('stockgroups/edit');
	
	$val = Model_Stockgroup::validate('edit');

	if ($val->run())
	{
	    $stockgroup->name = Input::post('name');

	    if ($stockgroup->save())
	    {
		Session::set_flash('success', 'Updated stock group #' . $id);

		Response::redirect('stockgroups');
	    }
	    else
	    {
		Session::set_flash('error', 'Could not update stock group #' . $id);
	    }
	}
	else
	{
	    if (Input::method() == 'POST')
	    {
		$stockgroup->name = $val->validated('name');

		Session::set_flash('error', $val->error());
	    }

	   $view->set('stockgroup', $stockgroup, false);
	}

	
	\Theme::instance()->set_partial('content', $view);
    }

    public function action_delete($id = null)
    {
	is_null($id) and Response::redirect('stockgroups');

	if ($stockgroup = Model_Stockgroup::find($id))
	{
	    $stockgroup->delete();

	    Session::set_flash('success', 'Deleted stock group #' . $id);
	}
	else
	{
	    Session::set_flash('error', 'Could not delete stock group #' . $id);
	}

	Response::redirect('stockgroups');
    }

}
