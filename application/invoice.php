<?php

class invoice extends orm
{
	protected $data;
	protected $line;
	protected $line_del;
	
	public function __construct()
	{
		parent::__construct('invoice');
		$this->data = field::array_from_string('id,rev,client_id,number,status,date,po_number,discount,notes,currency_code');
		
		$this->data['status']->type = 1;
		
		$this->line = new dtc_array();
		$this->line_del = new dtc_array();
	}
	
	public function line_new()
	{
		$this->line_add(new invoice_line());
	}
	
	public function line_add(invoice_line $line)
	{
		$k = count($this->line);
		$this->line[$k] = $line;
	}
	
	public function line_del($list)
	{
		foreach($list as $k)
		{
			$line = $this->line[$k];
			unset($this->line[$k]);
			$k = count($this->line_del);
			$this->line_del[$k] = $line;
		}
	}
	
	public function line() { return $this->line; }
	
	public function get_helper()
	{
		parent::get_helper();
		$db = my_db::get_instance();
		$this->line->clear();
		$this->line_del->clear();
		foreach($db->query('select id from invoice_line where invoice_id=?', $this->data['id']->value) as $row)
		{
			$line = new invoice_line();
			$line->id = $row['id'];
			$line->get();
			$this->line_add($line);
		}
	}
	
	public function set_helper()
	{
		parent::set_helper();
		
		foreach($this->line as $line)
		{
			$line->invoice_id = $this->data['id']->value;
			$line->set();
		}
		
		foreach($this->line_del as $line) $line->del();
		$this->line_del->clear();
	}
}

?>