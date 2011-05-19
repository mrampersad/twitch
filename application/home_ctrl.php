<?php

class home_ctrl extends my_ctrl
{
	public $ex;
	public $invoice;
	public $view;

	public function __construct()
	{
		parent::__construct();
		
		$this->invoice = new invoice();
		
		if(!empty($_GET['id']))
		{
			$this->invoice->id = $_GET['id'];
			$this->invoice->get();
			unset($_GET['id']);
		}
		
		$this->view = new invoice_view($this);
	}
	
	public function index()
	{
		$this->view->index();
	}
	
	public function post()
	{
		$this->ex = null;
		
		try
		{
			html::dop($this->invoice->data(), 'client_id,number,date,po_number,notes');
			foreach($this->invoice->line() as $line) html::dop($line->data(), 'name,description,unit_cost,quantity,tax1_name,tax2_name');
			
			switch(key($_POST['action']))
			{
				case 'line_new':
					$this->invoice->line_new();
					$this->view->line_new();
					break;
				case 'line_del':
					if(!empty($_POST['line'])) $this->invoice->line_del($_POST['line']);
					$this->view->line_del();
					break;
				case 'set':
					$this->invoice->set();
					$this->view->set();
					break;
				default:
					throw new Exception();
			}
		}
		catch(Exception $ex)
		{
			$this->ex = $ex;
			$this->view->ex();
		}
	}
}

?>