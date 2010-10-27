<?php

class text
{
	protected $name;
	protected $value;

	public function __construct($value = 0)
	{
		$this->name = uuid::gen();
		$this->value = $value;
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
		echo '<input type="checkbox" name="' . $this->name . '" value="1"';
		if($this->value) echo ' checked="checked"';
		echo ' />';
	}
}

?>