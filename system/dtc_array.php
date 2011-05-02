<?php

class dtc_array implements ArrayAccess, Iterator, Countable
{
	protected $data;
	protected $tx_data;
	protected $cur;
	
	public function __construct() { dtc::get_instance()->register($this); $this->clear(); }
	public function __wakeup() { dtc::get_instance()->register($this); }
	
	public function offsetExists($k) { return isset($this->data[$k]); }
	public function &offsetGet($k) { return $this->data[$k]; }
	public function offsetSet($k, $v) { $this->data[$k] = $v; }
	public function offsetUnset($k) { unset($this->data[$k]); }
	
	public function begin() { $this->tx_data = $this->data; }
	public function commit() { }
	public function rollback() { $this->data = $this->tx_data; }

	public function rewind() { reset($this->data); $this->next(); }
	public function valid() { return $this->cur != false; }
	public function next() { $this->cur = each($this->data); }
	public function key() { return $this->cur[0]; }
	public function current() { return $this->cur[1]; }
	
	public function count() { return count($this->data); }
	
	public function clear() { $this->data = array(); }
}

?>