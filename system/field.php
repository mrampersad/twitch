<?php

class field
{
	public $name, $value, $required;
	protected $tx_value;

	public function __construct($value = null)
	{
		$this->name = uuid::gen();
		$this->value = $value;
		$this->required = true;
		
		dtc::get_instance()->register($this);
	}
	
	public function __wakeup()
	{
		dtc::get_instance()->register($this);
	}
	
	public function post()
	{
		if(isset($_POST[$this->name]))
		{
			if(!is_array($_POST[$this->name])) throw new Exception('POST Error');
			foreach(array_keys($_POST[$this->name]) as $k) $_POST[$this->name][$k] = trim($_POST[$this->name][$k]);
			$this->value = join(',', $_POST[$this->name]);
			if($this->value === '') $this->value = null;
		}
		else
		{
			if($this->required) throw new Exception('POST Error');
			$this->value = null;
		}
	}
	
	public function __toString() { return (string)$this->value; }
	
	public function begin() { $this->tx_value = $this->value; }
	public function commit() { }
	public function rollback() { $this->value = $this->tx_value; }
	
	public static function array_from_string($s) { $result = array(); foreach(explode(',', $s) as $k) $result[$k] = new field(); return $result; }
	public static function to_array($a) { $r = array(); foreach($a as $k => $v) $r[$k] = $v->value; return $r; }
	public static function array_load($f, $a) { foreach($a as $k => $v) $f[$k]->value = $v; }
}

?>