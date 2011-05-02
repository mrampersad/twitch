<?php

class engine
{
	public static function run()
	{
		if(!isset($_SERVER['REDIRECT_URL'])) throw new Exception();

		$controller = 'home';
		$function = 'index';

		$_SERVER['REDIRECT_URL'] = substr($_SERVER['REDIRECT_URL'], strlen(config::prefix()));
		$path = explode('/', $_SERVER['REDIRECT_URL']);
		if($path && preg_match('/^[0-9a-z]+$/i', $path[0]))
		{
			$controller = array_shift($path);
			
			if($path && preg_match('/^[0-9a-z]+$/i', $path[0]))
			{
				$function = array_shift($path);
			}
		}

		state::run($controller, $function);
	}
}

?>