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
	
	public function post()
	{
		switch($this->type)
		{
			case 0:
				if(!isset($_POST[$this->name])) throw new Exception('POST Error');
				$this->value = trim($_POST[$this->name]);
				if($this->value === '') $this->value = null;
				break;
			case 1:
				if(isset($_POST[$this->name]) && !is_array($_POST[$this->name])) throw new Exception('POST Error');
				$this->value = empty($_POST[$this->name]) ? null : join(',', $_POST[$this->name]);
				break;
			default:
				throw new Exception('Type not implemented.');
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