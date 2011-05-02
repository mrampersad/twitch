<?php

class db_expression
{
	protected $expression;
	
	function __construct($expression)
	{
		$this->expression = $expression;
	}
	
	function __toString()
	{
		return $this->expression;
	}
}

?>