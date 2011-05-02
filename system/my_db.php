<?php

class my_db extends db
{
	protected static $instance = null;
	
	public static function get_instance()
	{
		if(is_null(my_db::$instance))
		{
			my_db::$instance = new my_db();
			my_db::$instance->connect(config::my_db_host(), config::my_db_user(), config::my_db_pass(), config::my_db_database(), config::my_db_charset());
		}
		
		return my_db::$instance;
	}
}

?>