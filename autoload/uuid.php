<?php

class uuid
{
	public static function check($uuid)
	{
		return preg_match('/[0-9a-z]{25}/', $uuid);
	}

	public static function gen()
	{
		$uuid = '';
		for($i = 0; $i < 25; $i++)
		{
			$x = rand(48, 83);
			if($x >= 58) $x += 39;
			$uuid .= chr($x);
		}
		
		return $uuid;
	}
}

?>