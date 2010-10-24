<?php

class user_ctrl extends ctrl
{
	protected $name;
	protected $client;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->name = new text('Testing');
		$this->client = array();
	}
	
	public function index()
	{
		util::form($this);
		
		echo '<input type="submit" name="action[set]" value="Set" />';
		echo '<br />';
		
		$this->name->render();
		echo '<br />';
		
		foreach($this->client as $i => $client)
		{
			$client->givenname()->render();
			$client->surname()->render();
			echo '<input type="submit" name="action[remove][' . $i . ']" value="Remove Client" />';
			echo '<br />';
		}
		
		echo '<input type="submit" name="action[add]" value="Add Client" />';
		echo '<input type="submit" name="action[save]" value="Commit" />';
		echo '<input type="submit" name="action[cancel]" value="Cancel" />';
		echo '</form>';
	}
	
	public function post()
	{
		$this->name->post();
		foreach($this->client as $client) $client->post();
		
		switch(key($_POST['action']))
		{
			case 'set':
				break;
			case 'commit':
				// perform the save
				break;
			case 'add':
				$this->client[] = new client();
				break;
			case 'remove':
				unset($this->client[key($_POST['action']['remove'])]);
				break;
			case 'cancel':
				util::redirect();
			default:
				throw new Exception('Unrecognized option.');
		}
		
		util::redirect($this);
	}
}

?>