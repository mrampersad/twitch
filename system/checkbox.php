<?php

class checkbox
{
	protected $name;
	protected $value;

	public function __construct($value = 0)
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
		$this->value = (integer)isset($_POST[$this->name]);
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
		echo ' type="checkbox"';
		echo ' name="' . $this->name . '"';
		echo ' value="1"';
		if($this->value) echo ' checked="checked"';
		echo ' />';
	}
}

?>