<?php

class dtc
{
	protected static $instance = null;
	
	public static function get_instance()
	{
		if(is_null(dtc::$instance)) dtc::$instance = new dtc();
		return dtc::$instance;
	}
	
	protected $in_tx;
	protected $obj;
	
	protected function __construct()
	{
		$this->in_tx = false;
		$this->obj = array();
	}
	
	public function in_tx()
	{
		return $this->in_tx;
	}
	
	public function register($obj)
	{
		$this->obj[] = $obj;
		
		// join a transaction in progress
		if($this->in_tx) $obj->begin();
	}
	
	public function begin()
	{
		try
		{
			foreach($this->obj as $v) $v->begin();
			$this->in_tx = true;
		}
		catch(Exception $ex)
		{
			throw new dtc_abort_ex();
		}
	}
	
	public function commit()
	{
		try
		{
			foreach($this->obj as $v) $v->commit();
			$this->in_tx = false;
		}
		catch(Exception $ex)
		{
			throw new dtc_abort_ex();
		}
	}

	public function rollback()
	{
		try
		{
			foreach($this->obj as $v) $v->rollback();
			$this->in_tx = false;
		}
		catch(Exception $ex)
		{
			throw new dtc_abort_ex();
		}
	}
}

?>