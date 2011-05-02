<?php

class html
{
	public static function tag($name, $data)
	{
		$s = '<' . $name;
		foreach($data as $k => $v) $s .= ' ' . $k . '="' . util::html($v) . '"';
		$s .= ' />';
		return $s;
	}
	
	public static function text(field $field, $extra = '') { printf('<input type="text" %s name="%s" value="%s" />', $extra, $field->name, $field->value); }
	public static function radio(field $field, $value, $extra = '') { printf('<input type="radio" %s name="%s" value="%s" %s />', $extra, $field->name, $value, $field->value == $value ? 'checked="checked"' : ''); }
	public static function option(field $field, $value, $name, $extra = '') { printf('<option %s value="%s" %s>%s</option>', $extra, $value, $field->value == $value ? 'selected="selected"' : '', $name); }
	public static function checkbox(field $field, $extra = '') { printf('<input type="checkbox" %s name="%s" value="1" %s />', $extra, $field->name, $field->value ? 'checked="checked"' : ''); }

	public static function pget($k) { if(!isset($_POST[$k])) throw new Exception('input missing'); return $_POST[$k]; }
	public static function dop($i, $s) { foreach(explode(',', $s) as $k) $i[$k]->post(); }
	
	public static function form_start($controller, $function = 'post', $parameters = array(), $extra = '') { printf('<form action="%s" method="post" enctype="multipart/form-data" %s>', util::href($controller, $function, $parameters), $extra); }
	public static function form_end() { printf('</form>'); }
}

?>