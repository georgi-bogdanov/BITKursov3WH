<?php

/**
 * Stocks Controller
 * 
 * @author Stefan Dyankov <s.dyankov@gmail.com>
 * @copyright (c) 2013
 */
class Controller_Stocks extends \Controller_Base_User
{

    /**
     * The Stocks action for the application.
     *
     * @access  public
     * @return  Response
     */
    public function action_index()
    {
	$this->_append_title('Stocks');

	$view = \Theme::instance()->view('stocks/index');
	$view->set('stocks', Model_Stock::find('all', array('order_by' => array('id'=>'desc'))));
	\Theme::instance()->set_partial('content', $view);
    }

    public function action_edit($stock_id = 0)
    {
	$stock = NULL;

	list($driver, $user_id) = $this->auth_instance->get_user_id();

	//check if user is admin if not redirect him/her to the main site.
	if (!$this->auth_instance->member(50) && !$this->auth_instance->member(100))
	{
	    Response::redirect('home');
	}

	$this->_append_title('Create Stock');

	if ($stock_id)
	{
	    $stock = Model_Stock::find('first', array('where' => array('id' => $stock_id)));
	    if (!$stock)
	    {
		Session::set_flash('error', 'Invalid stock.');
	    }
	}


	if (Input::method() == 'POST')
	{
	    $val = Model_Stock::validate('create');

	    if ($val->run())
	    {
		if (!isset($stock) || !$stock)
		{
		    $stock = Model_Stock::forge(array(
				'name' => Input::post('name'),
				'user_id' => $user_id,
				'qty' => Input::post('qty'),
				'description' => Input::post('description'),
				'stockgroup_id' => Input::post('stockgroup_id'),
		    ));
		}
		else
		{
		    $stock->name = Input::post('name');
		    $stock->qty = Input::post('qty');
		    $stock->description = Input::post('description');
		    $stock->stockgroup_id = Input::post('stockgroup_id');
		}

		if ($stock and $stock->save())
		{
		    if (!$stock_id)
		    {
			Session::set_flash('success', 'Added stock #' . $stock->id . '.');
		    }
		    else
		    {
			Session::set_flash('success', 'Edit stock #' . $stock->id . '.');
		    }

		    Response::redirect('stocks/edit/' . $stock->id);
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

	$view = \Theme::instance()->view('stocks/edit');
	$stockgroups = Model_Stockgroup::find('all');
	$stockgroups_select = array('' => 'Please Select');
	foreach ($stockgroups as $stockgroup)
	{
	    $stockgroups_select[$stockgroup->id] = $stockgroup->name;
	}
	$view->set('stockgroups', $stockgroups_select);
	$view->set('stock', $stock);
	\Theme::instance()->set_partial('content', $view);
    }

    public function action_view($stock_id)
    {
	$stock = Model_Stock::find($stock_id);

	if (!$stock)
	{
	    Session::set_flash('error', 'There is no such stock.');
	    Response::redirect('home');
	}

	$view = \Theme::instance()->view('stocks/view');
	$view->set('stock', $stock);
	\Theme::instance()->set_partial('content', $view);
    }

    public function action_delete($id = null)
    {
	is_null($id) and Response::redirect('stocks');

	if ($stock = Model_Stock::find($id))
	{
	    $stock->delete();

	    Session::set_flash('success', 'Deleted stock #' . $id);
	}
	else
	{
	    Session::set_flash('error', 'Could not delete stock #' . $id);
	}

	Response::redirect('stocks');
    }

}

/* EOF */