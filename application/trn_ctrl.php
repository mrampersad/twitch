<?php

class trn_ctrl extends ctrl
{
	protected $message;
	protected $id;
	protected $name;
	protected $date;
	protected $entry;
	protected $total;
	
	protected $account;
	protected $db;
	
	public function __construct()
	{
		parent::__construct();
		security::logged_in();
		
		$this->db = my_db::open();
		
		$this->message = '';
		$this->id = null;
		$this->name = new text();
		$this->date = new text();
		$this->entry = array();
		$this->total = 0;
		
		$this->account = array();
		$this->account = acc_ctrl::_load_account();
	}
	
	public function load()
	{
		if(!isset($_REQUEST['id'])) throw new Exception();
		$this->db->query('begin');
		$tx = $this->db->get($_REQUEST['id'], 'trn');
		if(!$tx) throw new Exception();
		$this->id = $tx['id'];
		$this->name = new text($tx['name']);
		$this->date = new text($tx['dte']);
		foreach($this->db->query('select * from ent where trn_id=?', $this->id) as $entry) $this->add_entry($entry['id'], $entry['acc_id'], $entry['amount']);
		$this->db->query('commit');
		$this->index();
	}
	
	public function index()
	{
		if($this->message) echo '<p>' . $this->message . '</p>';
		
		util::form($this);
		
		echo '<input type="submit" name="action[set]" value="Set" />';
		echo '<br />';
		
		echo $this->name->render();
		echo $this->date->render();
		echo '<br />';
		
		echo '<table>';
		$total = 0;
		foreach($this->entry as $i => $entry)
		{
			echo '<tr>';
			echo '<td>'; $entry['acc_id']->render(); echo '</td>';
			echo '<td>'; $entry['amount']->render(); echo '</td>';
			$total += (float)$entry['amount']->value();
			echo '<td><input type="submit" name="action[remove][' . $i . ']" value="Remove" /></td>';
			echo '</tr>';
		}
		
		echo '<tr><td>Total</td><td>' . sprintf('%1.2f', $this->total) . '</td><td></td></tr>';
		echo '</table>';
		
		echo '<input type="submit" name="action[add]" value="Add Entry" />';
		echo '<br />';
		
		echo '<input type="submit" name="action[commit]" value="Commit" />';
		echo '<input type="submit" name="action[cancel]" value="Cancel" />';
		echo '</form>';
	}
	
	public function post()
	{
		$this->message = '';
			
		$this->name->post();
		$this->date->post();
		
		$this->total = 0;
		foreach($this->entry as $entry)
		{
			$entry['acc_id']->post();
			$entry['amount']->post();
			$this->total += (float)$entry['amount']->value();
		}
		
		switch(key($_POST['action']))
		{
			case 'set':
				break;
			case 'commit':
				// validate
				if(abs($this->total) < 0.01)
				{
					if(count($this->entry) > 1)
					{
						$ok = true;
						
						foreach($this->entry as $entry)
						{
							if(abs($entry['amount']->value()) < 0.01)
							{
								$ok = false;
							}
						}
						
						if($ok)
						{
							$this->db = my_db::open();
							$this->db->query('begin');
							
							$this->id = $this->db->set($this->id, 'trn', array('name' => $this->name->value(), 'dte' => $this->date->value()));
							
							$ids = array();
							foreach($this->entry as $entry) if($entry['id']) $ids[] = $entry['id'];
							if($ids) $this->db->query('delete from ent where trn_id=? and id not in (' . join(',', $ids) . ')', $this->id);
							
							foreach($this->entry as &$entry)
							{
								$entry['id'] = $this->db->set($entry['id'], 'ent', array('trn_id' => $this->id, 'acc_id' => $entry['acc_id']->value(), 'amount' => $entry['amount']->value()));
							}
							unset($entry);
							
							$this->db->query('commit');
							util::redirect('trn', 'load', array('id' => $this->id));
						}
						else
						{
							$this->message = 'One or more entries has a balance of 0.00';
						}
					}
					else
					{
						$this->message = 'There must be two or more entries to commit.';
					}
				}
				else
				{
					$this->message = 'Your total must be 0.00';
				}
				
				break;
			case 'cancel':
				util::redirect('secure');
			case 'remove':
				$i = key($_POST['action']['remove']);
				$this->total -= $this->entry[$i]['amount']->value();
				unset($this->entry[$i]);
				break;
			case 'add':
				$this->add_entry();
				break;
		}
	
		util::redirect($this);
	}
	
	protected function add_entry($id = null, $account_id = '', $amount = '')
	{
		$entry = array();
		$entry['id'] = $id;
		$entry['acc_id'] = new sel($this->account, $account_id);
		$entry['amount'] = new text($amount);
		$this->entry[] = $entry;
	}
}

?>