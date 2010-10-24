<?php

class acc_ctrl extends ctrl
{
	protected $id;
	protected $acc_id;
	protected $name;
	protected $total;

	public function __construct()
	{
		parent::__construct();
		security::logged_in();
		
		$this->id = null;
		$arr = array(0 => '') + acc_ctrl::_load_account();
		$this->acc_id = new sel($arr);
		$this->name = new text();
		$this->total = 0;
	}
	
	public static function _load_account($parent= null, $prefix = '')
	{
		$db = my_db::open();
		
		$result = array();
		foreach($db->query('select id, name, total from acc where acc_id ' . ($parent ? '=' . $db->esc($parent) : 'is null') . ' order by name') as $account)
		{
			$result[$account['id']] = $prefix . $account['name'] . ' (' . $account['total'] . ')';
			$result += acc_ctrl::_load_account($account['id'], $prefix . $account['name'] . ' > ');
		}
		return $result;
	}
	
	public function load()
	{
		if(!isset($_REQUEST['id'])) throw new Exception();
		$db = my_db::open();
		$acc = $db->get($_REQUEST['id'], 'acc');
		$this->id = $acc['id'];
		$this->name->setValue($acc['name']);
		$this->acc_id->setValue($acc['acc_id']);
		$this->index();
	}
	
	public function index()
	{
		util::form($this);
		
		$this->acc_id->render();
		$this->name->render();
		
		echo '<input type="submit" name="action[save]" value="Save" />';
		echo '<input type="submit" name="action[cancel]" value="Cancel" />';
		
		echo '</form>';
	}
	
	public function post()
	{
		$this->acc_id->post();
		if(!$this->acc_id->value()) $this->acc_id->setValue(null);
		$this->name->post();
		
		switch(key($_POST['action']))
		{
			case 'save':
				$this->save();
				break;
			case 'cancel':
				util::redirect('access');
		}
	}
	
	protected function save()
	{
		$db = my_db::open();
		$db->set($this->id, 'acc', array('acc_id' => $this->acc_id->value(), 'name' => $this->name->value(), 'total' => $this->total));
		util::redirect('acc', 'load', array('id' => $this->id));
	}
}

?>