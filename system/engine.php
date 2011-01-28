<?php

class engine
{
	public static function run()
	{
		if(!isset($_SERVER['REDIRECT_URL'])) throw new Exception();
		
		$_SERVER['REDIRECT_URL'] = substr($_SERVER['REDIRECT_URL'], strlen(config::prefix()));
		
		$path = explode('/', $_SERVER['REDIRECT_URL']);
		//array_shift($path);

		if($path && preg_match('/^[0-9a-z]+$/i', $path[0]))
		{
			req::$controller = array_shift($path);
			
			if($path && preg_match('/^[0-9a-z]+$/i', $path[0]))
			{
				req::$function = array_shift($path);
			}
		}

		unset($path);

		session_start();

		if(uuid::check(req::$controller))
		{
			$obj = state::load(req::$controller);
			if(!$obj instanceof ctrl) throw new Exception();
			call_user_func(array($obj, req::$function));
		}
		else
		{
			$obj = eval('return new ' . req::$controller . '_ctrl();');
			if(!$obj instanceof ctrl) throw new Exception();
			util::redirect($obj, req::$function, $_GET);
		}
	}
}

?>