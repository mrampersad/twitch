<?php

class my_ctrl extends ctrl
{
	public function __construct()
	{
		$this->check_session();
	}
	
	public function __wakeup()
	{
		$this->check_session();
	}
	
	protected function check_session()
	{
		$session = session::get_instance();
		
		if(!isset($session->created) || $session->created == null) $session->created = gmdate('Y-m-d H:i:s');
		$session->accessed = gmdate('Y-m-d H:i:s');
	}
}

?>