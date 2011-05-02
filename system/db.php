<?php

class db
{
	protected $link;
	protected $args;

	public function __construct()
	{
		dtc::get_instance()->register($this);
	}
	
	public function connect($host, $user, $pass, $base, $charset)
	{
		$this->link = mysql_connect($host, $user, $pass);
		if(!$this->link) throw new Exception(mysql_error(), mysql_errno());
		$this->query('SET NAMES ?', $charset);
		$this->query("USE `$base`");
		$this->in_tx = false;
	}
	
	public function query($sql)
	{
		$this->args = func_get_args();
		array_shift($this->args);
		
		if($this->args)
		{
			$sql = preg_replace_callback('/\?/', array($this, 'query_escape'), $sql);
		}
		
		$res = mysql_query($sql, $this->link);
		if(mysql_errno($this->link)) throw new Exception(mysql_error($this->link), mysql_errno($this->link));
		return new db_res($res);
	}
	
	public function query_escape($m)
	{
		if(!$this->args) throw new Exception('Malformed query.');
		return $this->escape(array_shift($this->args));
	}
	
	public function escape($v)
	{
		if(is_null($v))
		{
			return 'NULL';
		}
		elseif($v instanceof db_identifier)
		{
			return $v->__toString();
		}
		elseif($v instanceof db_expression)
		{
			return $v->__toString();
		}
		elseif(is_numeric($v))
		{
			return $v;
		}
		else
		{
			return "'" . mysql_real_escape_string((string)$v, $this->link) . "'";
		}
	}
	
	public function affected()
	{
		return mysql_affected_rows($this->link);
	}
	
	public function begin() { $this->query('begin'); }
	public function commit() { $this->query('commit'); }
	public function rollback() { $this->query('rollback'); }
}

?>