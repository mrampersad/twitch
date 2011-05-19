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
		$tax = array('' => '', 'HST' => 'HST');
	
		xhtml::head($this->ctrl->ex);
		html::form_start($this->ctrl);
?>
<table>
<tr>
	<td>Client</td>
	<td><?php html::text($this->ctrl->invoice->client_id); ?></td>
	<td>Invoice Number</td>
	<td><?php html::text($this->ctrl->invoice->number); ?></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td>Invoice Date</td>
	<td><?php html::text($this->ctrl->invoice->date); ?></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td>PO Number</td>
	<td><?php html::text($this->ctrl->invoice->po_number); ?></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td>Discount %</td>
	<td><?php html::text($this->ctrl->invoice->discount); ?></td>
</tr>
</table>

<table>
<tr>
	<td></td>
	<td>Item</td>
	<td>Description</td>
	<td>Unit Cost</td>
	<td>Qty</td>
	<td>Tax 1</td>
	<td>Tax 2</td>
	<td>Line Total</td>
</tr>
<?php foreach($this->ctrl->invoice->line() as $k => $v): ?>
<tr>
	<td><input type="checkbox" name="line[]" value="<?php echo $k; ?>" /></td>
	<td><?php html::text($v->name); ?></td>
	<td><?php html::textarea($v->description); ?></td>
	<td><?php html::text($v->unit_cost, 'size="8"'); ?></td>
	<td><?php html::text($v->quantity, 'size="5"'); ?></td>
	<td><?php html::select($v->tax1_name); foreach($tax as $k2 => $v2) html::option($v->tax1_name, $k2, $v2); html::select_end(); ?></td>
	<td><?php html::select($v->tax2_name); foreach($tax as $k2 => $v2) html::option($v->tax2_name, $k2, $v2); html::select_end(); ?></td>
	<td>0.00</td>
</tr>
<?php endforeach; ?>
</table>
<div><?php html::textarea($this->ctrl->invoice->notes); ?></div>
<div>
	<input type="submit" name="action[set]" value="Save" />
	<input type="submit" name="action[line_new]" value="Add Line" />
	<input type="submit" name="action[line_del]" value="Delete Selected Lines" />
</div>
<?php
		html::form_end();
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