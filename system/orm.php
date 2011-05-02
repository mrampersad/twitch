<?php

abstract class orm
{
	protected $table;
	protected $data;
	
	public function __construct($table)
	{
		$this->table = $table;
	}
	
	public function get()
	{
		$dtc = dtc::get_instance();
		
		$in_tx = $dtc->in_tx();
		if(!$in_tx) $dtc->begin(); // autocommit
		
		try
		{
			$this->get_helper();
		}
		catch(Exception $ex)
		{
			if(!$in_tx) $dtc->rollback();
			throw $ex;
		}
		
		if(!$in_tx) $dtc->commit();
	}
	
	public function set()
	{
		$dtc = dtc::get_instance();
		
		$in_tx = $dtc->in_tx();
		if(!$in_tx) $dtc->begin(); // autocommit
		
		try
		{
			$this->set_helper();
		}
		catch(Exception $ex)
		{
			if(!$in_tx) $dtc->rollback();
			throw $ex;
		}
		
		if(!$in_tx) $dtc->commit();
	}
	
	public function del()
	{
		$dtc = dtc::get_instance();
		
		$in_tx = $dtc->in_tx();
		if(!$in_tx) $dtc->begin(); // autocommit
		
		try
		{
			$this->del_helper();
		}
		catch(Exception $ex)
		{
			if(!$in_tx) $dtc->rollback();
			throw $ex;
		}
		
		if(!$in_tx) $dtc->commit();
	}
	
	protected function get_helper()
	{
		$rec = new rec(config::orm_db());
		$rec->get($this->table, $this->data);
	}
	
	protected function set_helper()
	{
		$rec = new rec(config::orm_db());
		$rec->set($this->table, $this->data);
	}
	
	protected function del_helper()
	{
		$rec = new rec(config::orm_db());
		$rec->del($this->table, $this->data);
	}
	
	public function __set($k, $v) { $this->data[$k]->value = $v; }
	public function __isset($k) { return isset($this->data[$k]); }
	public function __get($k) { return $this->data[$k]; }
	public function __unset($k) { unset($this->data[$k]); }
	
	public function data() { return $this->data; }
}

?>