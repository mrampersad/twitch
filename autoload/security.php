<?php

class security
{
	static function logged_in()
	{
		if(!isset($_SESSION['id'])) throw new Exception('not logged in');
	}
}

?>