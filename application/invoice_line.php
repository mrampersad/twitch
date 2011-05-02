<?php

class invoice_line extends orm
{
	public function __construct()
	{
		parent::__construct('invoice_line');
		$this->data = field::array_from_string('id,rev,invoice_id,name,description,unit_cost,quantity,tax1_name,tax2_name,type');
	}
}

?>