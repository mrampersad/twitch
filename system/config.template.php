<?php

class config
{
	public static function docroot()
	{
		return '/path/to/webroot';
	}
	
	public static function prefix()
	{
		return '/path/to/application';
	}
	
	public static function db_server()
	{
		return '127.0.0.1';
	}
	
	public static function db_username()
	{
		return 'username';
	}
	
	public static function db_password()
	{
		return 'password';
	}
	
	public static function db_database()
	{
		return 'database';
	}
}

?>