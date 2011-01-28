<?php

class session
{
	protected static $instance = null;
	
	public static function get_instance()
	{
		if(is_null(session::$instance)) session::$instance = new session();
		return session::$instance;
	}
	
	public function start()
	{
		session_start();
	}
}

?>