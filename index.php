<?php

ini_set('display_errors', 1);

// bootstrap the autoloader
require('autoload/config.php');
require('autoload/util.php');

function __autoload($autoload)
{
	include_once(util::base() . '/autoload/' . $autoload . '.php');
}

engine::run();

?>