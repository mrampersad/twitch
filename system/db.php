<?php

class db
{
	protected $server;
	protected $username;
	protected $password;
	protected $database;
	protected $charset;
	
	protected $link;
	protected $args;

	public function connect($server, $username, $password, $database, $charset = 'utf8')
	{
		$this->server = $server;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;
		$this->charset = $charset;
		
		$this->link = mysql_connect($this->server, $this->username, $this->password);
		if(!$this->link) throw new Exception(mysql_error());
		$this->query('set names ?', $this->charset);
		$this->query('use ' . $this->database);
	}
	
	public function __sleep()
	{
		return array('server', 'username', 'password', 'database', 'charset');
	}
	
	public function __wakeup()
	{
		$this->connect($this->server, $this->username, $this->password, $this->database, $this->charset);
	}
	
	public function query($sql)
	{
		$this->args = func_get_args();
		array_shift($this->args);
		if($this->args) $sql = preg_replace_callback('/\?/', array($this, 'query_helper'), $sql);
		$res = mysql_query($sql, $this->link);
		if($res === false) throw new Exception(mysql_error($this->link));
		if($res === true) return true;
		return new db_res($res);
	}
	
	public function query_helper($m)
	{
		return $this->esc(array_shift($this->args));
	}
	
	public function esc($v)
	{
		if(is_null($v)) return 'NULL';
		if(is_numeric($v)) return $v;
		return "'" . mysql_real_escape_string($v) . "'";
	}
	
	public function set(&$id, $table, $field)
	{
		$query = '';
		foreach($field as $key => $value) $query .= ",`$key`=" . $this->esc($value);
		$query = " `$table` set " . substr($query, 1);
		
		if($id)
		{
			$this->query('update' . $query . ' where id=' . $this->esc($id));
		}
		else
		{
			$this->query('insert' . $query);
			$ida = $this->query('select last_insert_id() id')->fetch();
			$id = $ida['id'];
		}
		
		return $id;
	}
	
	public function affected()
	{
		return mysql_affected_rows($this->link);
	}
	
	public function get($id, $table)
	{
		return $this->query('select * from `' . $table . '` where id=' . $this->esc($id))->fetch();
	}
}

?>