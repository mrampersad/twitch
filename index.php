<?php

ini_set('display_errors', 1);

// bootstrap the autoloader
require('system/config.php');
require('system/util.php');

function __autoload($autoload)
{
	if(file_exists(util::base() . '/application/' . $autoload . '.php'))
	{
		include(util::base() . '/application/' . $autoload . '.php');
	}
	elseif(file_exists(util::base() . '/system/' . $autoload . '.php'))
	{
		include(util::base() . '/system/' . $autoload . '.php');
	}
}

engine::run();

?>