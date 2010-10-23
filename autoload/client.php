<?php

class client
{
	protected $givenname;
	protected $surname;
	
	public function __construct()
	{
		$this->givenname = new text();
		$this->surname = new text();
	}
	
	public function givenname()
	{
		return $this->givenname;
	}
	
	public function surname()
	{
		return $this->surname;
	}
	
	public function post()
	{
		$this->givenname->post();
		$this->surname->post();
	}
}

?>