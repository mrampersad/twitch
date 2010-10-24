<?php

class my_db
{
	static function open()
	{
		$db = new db();
		$db->connect(config::db_server(), config::db_username(), config::db_password(), config::db_database(), 'utf8');
		return $db;
	}
}

?>