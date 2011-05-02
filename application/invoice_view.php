<?php

class invoice_view
{
	public $ctrl;
	
	public function __construct($ctrl)
	{
		$this->ctrl = $ctrl;
	}
	
	public function index()
	{
		xhtml::head($this->ctrl->ex);
		
		html::form_start($this->ctrl);
		
		echo '<div>';
		html::text($this->ctrl->invoice->client_id);
		html::text($this->ctrl->invoice->number);
		html::text($this->ctrl->invoice->status);
		html::text($this->ctrl->invoice->date);
		html::text($this->ctrl->invoice->po_number);
		html::text($this->ctrl->invoice->discount);
		html::text($this->ctrl->invoice->notes);
		html::text($this->ctrl->invoice->currency_code);
		echo '</div>';
		
		echo '<input type="submit" name="action[set]" value="Save" />';
		echo '<input type="submit" name="action[line_new]" value="Add Line" />';
		echo '<input type="submit" name="action[line_del]" value="Delete Selected Lines" />';
		
		echo '<table>';
		
		foreach($this->ctrl->invoice->line() as $k => $v)
		{
			echo '<tr>';
			echo '<td><input type="checkbox" name="line[]" value="' . $k . '" /></td>';
			echo '<td>'; html::text($v->name); echo '</td>';
			echo '<td>'; html::text($v->description); echo '</td>';
			echo '<td>'; html::text($v->unit_cost); echo '</td>';
			echo '<td>'; html::text($v->quantity); echo '</td>';
			echo '<td>'; html::text($v->tax1_name); echo '</td>';
			echo '<td>'; html::text($v->tax2_name); echo '</td>';
			echo '<td>'; html::text($v->type); echo '</td>';
			echo '</tr>';
		}
		
		echo '</table>';
		
		html::form_end();
		
		echo '<pre>' . htmlentities(print_r($this->ctrl->invoice, true)) . '</pre>';
		
		xhtml::foot();
	}
	
	public function line_new()
	{
		util::redirect($this->ctrl);
	}
	
	public function line_del()
	{
		util::redirect($this->ctrl);
	}
	
	public function set()
	{
		util::redirect($this->ctrl);
	}
	
	public function ex()
	{
		util::redirect($this->ctrl);
	}
}

?>