<?php

class pass
{
	protected $name;
	public $value;

	public function __construct($value = '')
	{
		$this->name = uuid::gen();
		$this->value = $value;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function post()
	{
		if(!isset($_POST[$this->name])) throw new Exception('Form Incomplete.');
		$this->value = $_POST[$this->name];
	}
	
	public function value()
	{
		return $this->value;
	}
	
	public function setValue($value)
	{
		$this->value = $value;
	}
	
	public function render()
	{
		echo '<input';
		echo ' id="' . $this->name . '"';
		echo ' type="password"';
		echo ' name="' . $this->name . '"';
		echo ' />';
	}
}

?>