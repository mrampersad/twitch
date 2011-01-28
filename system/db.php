<?php

class db
{
	protected static $instance = null;
	
	public static function get_instance()
	{
		if(is_null(db::$instance)) db::$instance = new db();
		return db::$instance;
	}
	
	protected $link;
	protected $args;

	public function __construct()
	{
		$this->connect();
	}
	
	public function connect()
	{
		$this->link = mysql_connect(config::db_host(), config::db_user(), config::db_pass());
		if(!$this->link) throw new db_ex(mysql_error(), mysql_errno());
		$this->query('set names ?', config::db_charset());
		$this->query('use ' . config::db_database());
	}
	
	public function __wakeup()
	{
		$this->connect();
	}

	// called with just $sql, passes through query untouched
	// called with $sql, $arg1, $arg2, $arg3, replaces ? in $sql with $arg1, $arg2, $arg3
	// called with $sql, array($arg1, $arg2, $arg3) replaces ? in $sql with $arg1, $arg2, $arg3
	public function query($sql)
	{
		if(func_num_args() > 1)
		{
			$this->args = func_get_args();
			array_shift($this->args);
			if(is_array($this->args[0])) $this->args = $this->args[0];
			$sql = preg_replace_callback('/\?/', array($this, 'query_helper'), $sql);
		}
		
		$res = mysql_query($sql, $this->link);
		if($res === false) throw new db_ex(mysql_error($this->link), mysql_errno($this->link));
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
		if(is_float($v) || is_integer($v)) return $v;
		return "'" . mysql_real_escape_string((string)$v) . "'";
	}
	
	public function affected()
	{
		return mysql_affected_rows($this->link);
	}
}

?>