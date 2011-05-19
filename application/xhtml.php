<?php

class xhtml
{
	public static function head($ex = null)
	{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<style type="text/css">
body
{
	font-family: arial;
}

div.exception
{
	color: #F00;
	border: 1px solid #F00;
	padding: 1em;
	background: #FEE;
	margin-bottom: 1em;
}

table
{
	border-collapse: collapse;
}

td
{
	vertical-align: top;
	border: 1px solid black;
	padding: 0.25em;
}
</style>
</head>
<body>
<?php if($ex): ?>
<div class="exception">
<?php echo util::html($ex->getMessage()); ?>
</div>
<?php endif; ?>
<?php
	}

	public static function foot()
	{
?>
</body>
</html>
<?php
	}
}

?>