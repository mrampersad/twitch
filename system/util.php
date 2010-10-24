<?php

class util
{
	public static function webroot()
	{
		return 'http://' . $_SERVER['HTTP_HOST'] . config::prefix();
	}
	
	public static function base()
	{
		return config::docroot() . config::prefix();
	}
	
	public static function form($ctrl, $func = 'post', $req = array())
	{
		echo '<form action="' . util::html(util::href($ctrl, $func)) . '" method="post" enctype="multipart/form-data">';
	}
	
	public static function href($ctrl = 'home', $func = 'index', $req = array(), $sep = '&')
	{
		if($ctrl instanceof ctrl) $ctrl = state::save($ctrl);
		return util::webroot() . '/' . $ctrl . '/' . $func . '?' . http_build_query($req, '', $sep);
	}
	
	public static function redirect($ctrl = 'home', $func = 'index', $req = array())
	{
		header('Location: ' . util::href($ctrl, $func, $req));
		exit();
	}
	
	public static function link($body = 'Home', $ctrl = 'home', $func = 'index', $req = array())
	{
		return '<a href="' . util::html(util::href($ctrl, $func, $req)) . '">' . util::html($body) . '</a>';
	}
	
	public static function html($s)
	{
		return htmlentities($s, ENT_COMPAT, 'UTF-8');
	}
}

?>