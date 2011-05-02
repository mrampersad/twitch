<?php

class log
{
	public static function msg($s)
	{
		file_put_contents(util::base() . 'log.txt', $s . "\r\n", FILE_APPEND);
	}
}

?>