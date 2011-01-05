<?php

class my_db
{
	static function open()
	{
		$db = new db();
		$db->connect('127.0.0.1', 'username', 'password', 'database', 'utf8');
		return $db;
	}
}

?>