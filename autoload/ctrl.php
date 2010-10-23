<?php

abstract class ctrl
{
	protected $session_id;
	
	public function __construct()
	{
		$this->session_id = session_id();
	}
	
	public function __wakeup()
	{
		if($this->session_id != session_id())
		{
			throw new Exception('incorrect session');
		}
	}
}

?>