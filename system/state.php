<?php

class state
{
	public static function save($obj)
	{
		$uuid = uuid::gen();
		file_put_contents(util::base() . '/state/' . $uuid, serialize($obj));
		return $uuid;
	}
	
	public static function load($uuid)
	{
		if(!uuid::check($uuid)) throw new Exception('expected uuid');
		$obj = unserialize(file_get_contents(util::base() . '/state/' . $uuid));
		return $obj;
	}
	
//	public static function redirect($obj, $func = 'index')
//	{
//		$uuid = self::save($obj);
//		util::redirect($uuid, $func);
//	}
	
//	public static function form($obj, $func = 'post')
//	{
//		echo '<form action="' . util::href(self::save($obj), $func) . '" method="post" enctype="multipart/form-data">';
//	}
}

?>