<?php

class session
{
	protected static $instance = null;
	
	public static function get_instance()
	{
		if(is_null(session::$instance))
		{
			session::$instance = new session();
			session::$instance->load();
		}
		
		return session::$instance;
	}
	
	protected $data;
	
	protected function __construct()
	{
		$this->data = array();
	}
	
	public function load()
	{
		$db = config::session_db();
		
		if(!empty($_COOKIE['id']))
		{
			// confirm this is a valid cookie id.
			$row = $db->query('select * from `session` where `id`=?', $_COOKIE['id'])->fetch();
			if($row)
			{
				$this->data = $row;
			}
			else
			{
				unset($_COOKIE['id']);
			}
		}
		
		if(empty($_COOKIE['id']))
		{
			$this->data['id'] = uuid::gen();
			setcookie('id', $this->data['id'], 0, '/', '', true, true);
			$this->save();
		}
	}
	
	public function save()
	{
		$db = config::session_db();

		$args = array(0 => '');
		foreach($this->data as $k => $v)
		{
			$args[0] .= ",`$k`=?";
			$args[] = $v;
		}
		
		$args[0] = ' `session` set ' . substr($args[0], 1);
		
		if(empty($_COOKIE['id']))
		{
			$args[0] = 'insert into' . $args[0];
		}
		else
		{
			$args[0] = 'update' . $args[0] . ' where `id`=?';
			$args[] = $this->id;
		}
		
		call_user_func_array(array($db, 'query'), $args);
	}
	
	public function regenerate_id()
	{
		$id = uuid::gen();
		$db = config::session_db();
		$db->query('update `session` set `id`=? where `id`=?', $id, $this->data['id']);
		$this->data['id'] = $id;
		setcookie('id', $this->data['id'], 0, '/', '', true, true);
	}
	
	public function __set($k, $v) { $this->data[$k] = $v; }
	public function __isset($k) { return isset($this->data[$k]); }
	public function __get($k) { return $this->data[$k]; }
	public function __unset($k) { unset($this->data[$k]); }
}

?>