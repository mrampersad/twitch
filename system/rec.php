<?php

class rec
{
	protected $db;
	
	public function __construct($db)
	{
		$this->db = $db;
	}
	
	public function get($table, $row)
	{
		$data = $this->db->query('select * from `' . $table . '` where `id`=?', $row['id']->value)->fetch();
		if(!$data) throw new Exception();
		foreach($row as $k => $v) $v->value = $data[$k];
	}
	
	public function set($table, $row)
	{
		$args = array(0 => '');
		
		if(empty($row['id']->value)) $row['rev']->value = 0;
		$row['rev']->value++;
		
		foreach($row as $k => $v)
		{
			$args[0] .= ",`$k`=?";
			$args[] = $v->value;
		}
		
		$args[0] = ' `' . $table . '` set ' . substr($args[0], 1);
		
		if(empty($row['id']->value))
		{
			$args[0] = 'insert into' . $args[0];
			call_user_func_array(array($this->db, 'query'), $args);
			$temp = $this->db->query('select last_insert_id() as `id`')->fetch();
			if(!$temp) throw new Exception();
			$row['id']->value = $temp['id'];
		}
		else
		{
			$args[0] = 'update' . $args[0] . ' where `rev`=? and `id`=?';
			$args[] = $row['rev']->value - 1;
			$args[] = $row['id']->value;
			call_user_func_array(array($this->db, 'query'), $args);
			if($this->db->affected() < 1) throw new Exception();
		}
	}
	
	public function del($table, $row)
	{
		if(!empty($row['id']->value))
		{
			$this->db->query('delete from `' . $table . '` where `id`=? and `rev`=?', $row['id']->value, $row['rev']->value);
			if($this->db->affected() < 1) throw new Exception();
			$row['id']->value = null;
		}
	}
}

?>