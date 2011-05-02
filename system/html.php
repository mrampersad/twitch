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
	
	public static function text(field $field, $extra = '') { printf('<input type="text" %s name="%s" value="%s" />', $extra, $field->name, html::esc($field->value)); }
	
	public static function radio(field $field, $value, $extra = '')
	{
		if($field-value == $value) $extra .= ' checked="checked"';
		printf('<input type="radio" %s name="%s" value="%s" />', $extra, $field->name, html::esc($value));
	}
	
	public static function select(field $field, $extra = '')
	{
		switch($field->type)
		{
			case 0:
				$name = $field->name;
				break;
			case 1:
				$name = $field->name . '[]';
				$extra .= ' multiple="multiple"';
				break;
			default:
				throw new Exception('FIELD Error');
		}
		
		printf('<select %s name="%s">', $extra, $name);
	}
	
	public static function select_end() { printf('</select>'); }
	
	public static function option(field $field, $value, $name, $extra = '')
	{
		switch($field->type)
		{
			case 0:
				$selected = $field->value == $value;
				break;
			case 1:
				$selected = in_array($value, explode(',', $field->value));
				break;
			default:
				throw new Exception('FIELD Error');
		}
		
		if($selected) $extra .= ' selected="selected"';
		printf('<option %s value="%s">%s</option>', $extra, html::esc($value), html::esc($name));
	}
	
	public static function checkbox(field $field, $value = '1', $extra = '')
	{
		if(in_array($value, explode(',', $field->value))) $extra .= ' checked="checked"';
		printf('<input type="checkbox" %s name="%s[]" value="%s" />', $extra, $field->name, html::esc($value));
	}

	public static function dop($i, $s) { foreach(explode(',', $s) as $k) $i[$k]->post(); }
	
	public static function form_start($controller, $function = 'post', $parameters = array(), $extra = '') { printf('<form action="%s" method="post" enctype="multipart/form-data" %s>', util::href($controller, $function, $parameters), $extra); }
	public static function form_end() { printf('</form>'); }
	
	public static function esc($s) { return htmlentities($s, ENT_COMPAT, 'UTF-8'); }
}

?>