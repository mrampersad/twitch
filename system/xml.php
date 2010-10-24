<?php

class xml
{
	protected $state;
	protected $buffer;
	
	public function __construct()
	{
		$this->state = 0; // Initial state.
	}

	public function parse($text)
	{
		// reset token state;
		
		for($i = 0; $i < strlen($text); $i++)
		{
			$this->input($text{$i});
		}
		
		$this->input(false);
	}
	
	protected function input($c)
	{
		switch($this->state)
		{
			case 0: // initial state
				switch($c)
				{
					case '<':
						$this->state = 1;
						break;
					default:
						$this->buffer = $c;
						$this->state = 2; // text
						break;
				}
				break;
			case 2: // text
				if($c === false)
				{
					$this->token($this->buffer);
				}
				elseif($c === '<')
				{
					$this->state = 1;
				}
				else
				{
					$this->buffer .= $c;
				}
				break;
		}
	}
}

?>