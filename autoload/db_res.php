<?php

class db_res implements Iterator
{
	protected $res;
	
	protected $key;
	protected $current;
	
	public function __construct($res)
	{
		$this->res = $res;
		$this->key = -1;
		$this->current = false;
	}
	
	public function fetch()
	{
		$this->next();
		return $this->current();
	}
	
	public function seek($row)
	{
		mysql_data_seek($this->res, $row);
		$this->key = $row - 1;
		$this->next();
	}
	
	public function count()
	{
		return mysql_num_rows($this->res);
	}
	
	public function rewind()
	{
		if($this->count())
		{
			$this->seek(0);
		}
	}
	
	public function valid()
	{
		return (bool)$this->current;
	}
	
	public function key()
	{
		return $this->key;
	}
	
	public function current()
	{
		return $this->current;
	}
	
	public function next()
	{
		$this->key++;
		$this->current = mysql_fetch_assoc($this->res);
	}
}

?>