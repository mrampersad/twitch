<?php

class state
{
	public static function save($obj)
	{
		$uuid = uuid::gen();
		$_SESSION['ctrl'][$uuid] = true;
		file_put_contents(util::base() . '/state/' . $uuid, serialize($obj));
		return $uuid;
	}
	
	public static function destroy($obj)
	{
		foreach(array_keys($_SESSION['ctrl']) as $k)
		{
			if($_SESSION['ctrl'][$k] === $obj)
			{
				unset($_SESSION['ctrl'][$k]);
				unlink(util::base() . '/state/' . $k);
				return;
			}
		}
		
		throw new exception('invalid object');
	}
	
	public static function load($uuid)
	{
		if(!uuid::check($uuid)) throw new Exception('expected uuid');
		if(!isset($_SESSION['ctrl'][$uuid])) throw new Exception('invalid uuid');
		$obj = unserialize(file_get_contents(util::base() . '/state/' . $uuid));
		return $obj;
	}
}

?>