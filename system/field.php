<?php

class field
{
	public $name, $value, $type;
	protected $tx_value;

	public function __construct($value = null)
	{
		$this->name = uuid::gen();
		$this->value = $value;
		$this->type = 0;
		
		dtc::get_instance()->register($this);
	}
	
	public function __wakeup()
	{
		dtc::get_instance()->register($this);
	}
	
	public function post() { $this->value = $this->type ? isset($_POST[$this->name]) : html::pget($this->name); }
	public function __toString() { return (string)$this->value; }
	
	public function begin() { $this->tx_value = $this->value; }
	public function commit() { }
	public function rollback() { $this->value = $this->tx_value; }
	
	public static function array_from_string($s) { $result = array(); foreach(explode(',', $s) as $k) $result[$k] = new field(); return $result; }
	public static function to_array($a) { $r = array(); foreach($a as $k => $v) $r[$k] = $v->value; return $r; }
	public static function array_load($f, $a) { foreach($a as $k => $v) $f[$k]->value = $v; }
}

?>