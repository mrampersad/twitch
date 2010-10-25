<?php

class uuid
{
	public static function check($uuid)
	{
		return preg_match('/[a-z]{28}/', $uuid);
	}

	public static function gen()
	{
		$uuid = '';
		for($i = 0; $i < 28; $i++) $uuid .= rand(97, 122);
		return $uuid;
	}
}

?>