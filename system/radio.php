<?php

class radio
{
	protected $name;
	protected $value;
	protected $set;

	public function __construct(&$set, $value = '')
	{
		$this->name = uuid::gen();
		$this->value = $value;
		$this->set = &$set;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function post()
	{
		if(!isset($_POST[$this->name])) throw new Exception('input missing');
		$this->value = $_POST[$this->name];
		if(!in_array($this->value, $this->set)) throw new Exception('invalid selection');
	}
	
	public function value()
	{
		return $this->value;
	}
	
	public function setValue($value)
	{
		$this->value = $value;
	}
	
	public function render($value)
	{
		echo '<input';
		echo ' type="radio"';
		if($value == $this->value) echo ' checked="checked"';
		echo ' id="' . $this->name . '"';
		echo ' name="' . util::html($this->name) . '"';
		echo ' value="' . util::html($value) . '"';
		echo ' />';
	}
}

?>