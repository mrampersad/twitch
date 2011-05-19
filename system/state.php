<?php

class state
{
	public static function save($obj)
	{
		$db = config::state_db();
		$id = uuid::gen();
		$db->query('insert into `state` set `id`=?, `session_id`=?, `data`=?', $id, session::get_instance()->id, serialize($obj));
		return $id;
	}
	
	public static function run($id, $function)
	{
		if(uuid::check($id))
		{
			$db = config::state_db();
			$row = $db->query('select * from `state` where `id`=? and `session_id`=?', $id, session::get_instance()->id)->fetch();
			if(!$row) throw new Exception();
			$obj = unserialize($row['data']);
			call_user_func(array($obj, $function));
		}
		else
		{
			$obj = eval('return new ' . $id . '_ctrl();');
			if(!$obj instanceof ctrl) throw new Exception();
			util::redirect($obj, $function, $_GET);
		}
	}
}

?>