<?php

class sel
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
		if(!isset($this->set[$this->value])) throw new Exception('invalid selection');
	}
	
	public function item()
	{
		return isset($this->set[$this->value]) ? $this->set[$this->value] : null;
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
		echo '<select';
		echo ' id="' . $this->name . '"';
		echo ' name="' . $this->name . '"';
		echo '>';
		foreach($this->set as $k => $v)
		{
			echo '<option';
			echo ' value="' . util::html($k) . '"';
			if($k == $this->value) echo ' selected="selected"';
			echo '>' . util::html($v) . '</option>';
		}
		echo '</select>';
	}
}

?>