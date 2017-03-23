<?php

if ( ! function_exists('page'))
{
	function page($name, $uses = NULL, $method = 'get', $in_menu = TRUE, $custom_uri = '')
	{
		return \Intelitkz\Laraveltools\Page::new($name, $uses, $method, $in_menu, $custom_uri);
	}
}