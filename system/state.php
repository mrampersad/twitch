<?php

class state
{
	public static function save($obj)
	{
		$uuid = uuid::gen();
		file_put_contents(util::base() . '/state/' . $uuid, serialize(array(state::key(), $obj)));
		return $uuid;
	}
	
	public static function load($uuid)
	{
		if(!uuid::check($uuid)) throw new Exception('expected uuid');
		list($key, $obj) = unserialize(file_get_contents(util::base() . '/state/' . $uuid));
		if(state::key() !== $key) throw new Exception('permission denied');
		return $obj;
	}
		
	public static function key()
	{
		if(!isset($_SESSION['state_key'])) $_SESSION['state_key'] = uuid::gen();
		return $_SESSION['state_key'];
	}
}

?>