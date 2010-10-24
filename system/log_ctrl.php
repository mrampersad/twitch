<?php

class log_ctrl extends ctrl
{
	protected $message;
	protected $name;
	protected $pass;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->name = new text();
		$this->pass = new pass();
		$this->message = '';
	}
	
	public function in()
	{
		echo $this->message;
	
		util::form($this);
		
		$this->name->render();
		$this->pass->render();
		
		echo '<input type="submit" value="submit" />';
		
		echo '</form>';
	}
	
	public function post()
	{
		try
		{
			$this->name->post();
			$this->pass->post();
			
			if($this->name->value() == 'martin' && $this->pass->value() == 'test')
			{
				session_regenerate_id();
				$_SESSION['id'] = 1;
				util::redirect();
			}
			else
			{
				sleep(1);
				$this->message = '<p>Please check your username and password and try again.</p>';
				util::redirect($this, 'in');
			}
		}
		catch(Exception $e)
		{
			$this->message = $e->getMessage();
			util::redirect($this, 'in');
		}
	}
	
	public function out()
	{
		unset($_SESSION['id']);
		
		echo 'You have been logged out. ' . util::link();
	}
}

?>