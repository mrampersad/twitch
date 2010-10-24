<?php

class access_ctrl extends ctrl
{
	protected $db;
	
	public function __construct()
	{
		parent::__construct();
		security::logged_in();
		$this->db = my_db::open();
	}
	
	protected function recurse($parent = null, $depth = 0)
	{
		foreach($this->db->query('select * from acc where acc_id ' . ($parent ? '=' . $parent : 'is null')) as $row)
		{
			echo '<tr>';
			echo '<td>' . $row['id'] . '</td>';
			echo '<td>' . str_repeat('&nbsp;', $depth * 8) . util::link($row['name'], 'acc', 'load', array('id' => $row['id'])) . '</td>';
			echo '<td>' . $row['total'] . '</td>';
			echo '</tr>';
			
			$this->recurse($row['id'], $depth + 1);
		}
	}
	
	public function index()
	{
		$this->fix();
		
		echo '<h1>Tree of Accounts</h1>';
		echo util::link('New Account', 'acc');
		echo '<table>';
		$this->recurse();
		echo '</table>';
		
		echo '<h1>Transaction List</h1>';
		echo '<p>' . util::link('Log out', 'log', 'out') . '</p>';
		echo '<p>' . util::link('New Transaction', 'tx') . '</p>';
		
		echo '<table>';
		
		foreach($this->db->query('select * from trn order by dte') as $trn)
		{
			echo '<tr><td colspan="2">' . util::link($trn['name'], 'tx', 'load', array('id' => $trn['id'])) . '</a> ' . $trn['dte'] . '</td></tr>';
			
			foreach($this->db->query('select ent.amount, acc.name from ent inner join acc on ent.acc_id = acc.id where trn_id=? order by ent.amount desc', $trn['id']) as $ent)
			{
				echo '<tr><td>' . $ent['name'] . '</td><td>' . $ent['amount'] . '</td></tr>';
			}
			
			echo '<tr><td colspan="2"><hr /></tr>';
		}
		
		echo '</table>';
	}
	
	protected function fix()
	{
		$this->db->query('update acc set total = coalesce((select sum(amount) from ent where ent.acc_id = acc.id), 0)');
		$this->fix_recurse();
	}

	protected function fix_recurse($parent = null)
	{
		$total = 0;
		
		foreach($this->db->query('select * from acc where acc_id ' . ($parent ? '=' . $parent : 'is null')) as $row)
		{
			$row['total'] += $this->fix_recurse($row['id']);
			$this->db->set($row['id'], 'acc', $row);
			$total += $row['total'];
		}
		
		return $total;
	}
}