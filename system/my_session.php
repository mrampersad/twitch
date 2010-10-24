<?php

/*
abstract class my_session extends session
{
	public function __construct()
	{
		parent::__construct();
		$this->__wakeup();
	}
	
	public function __wakeup()
	{
		parent::__wakeup();
		
		if(!isset($_SESSION['id']))
		{
			throw new Exception('not logged in');
		}
	}
}
*/

?>