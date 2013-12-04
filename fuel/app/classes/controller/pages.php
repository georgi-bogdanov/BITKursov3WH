<?php

/**
 * Pages Controller
 * 
 * @author Stefan Dyankov <s.dyankov@gmail.com>
 * @copyright (c) 2013
 */
class Controller_Pages extends \Controller_Base_Common
{
    public function action_index($page)
    {
	$view = \Theme::instance()->view('pages/page');
	
	
	switch ($page)
	{
	    case 'tos':
		
		$content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus egestas velit in libero venenatis viverra. Nulla in augue ut lacus pharetra aliquet. Praesent nec mi elit. Morbi mollis, erat vel egestas tristique, elit velit facilisis mauris, a ornare justo ligula quis lacus. Nam a porta ligula. Sed condimentum leo neque, ut consectetur nisl porttitor ut. Quisque accumsan sapien ut nulla semper posuere. Integer condimentum sollicitudin nisl id consequat. Proin gravida pharetra urna, at posuere justo facilisis sit amet.<br/>
<br/>
Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris posuere magna nunc, nec egestas elit egestas tempor. Suspendisse tincidunt, purus a aliquam cursus, ante lacus congue elit, eu luctus lorem est eget velit. Sed convallis mauris diam, sit amet faucibus urna interdum eget. Proin id scelerisque nisi. Curabitur adipiscing quam sapien, vehicula venenatis felis ullamcorper sed. Nunc eu mollis quam. Nam quis volutpat lectus. Sed placerat luctus ornare. Sed vulputate neque in ipsum ultrices posuere. Quisque et condimentum nisl, a posuere metus.';
		
		$view->set('title', 'Terms of service', false);
		$view->set('content', $content, false);
		
		break;
	}
        
        \Theme::instance()->set_partial('content', $view);
    }
}

/* EOF */