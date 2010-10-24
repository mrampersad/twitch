<?php

class home_ctrl extends ctrl
{
	function index()
	{
		echo 'Welcome! ' . util::link('Login', 'log', 'in') . ' or ' . util::link('Access', 'access');
	}
}

?>