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
	
	public static function select(field $field, $extra = '') { printf('<select %s name="%s%s" %s>', $extra, $field->name, $field->type == 1 ? '[]' : '', $field->type == 1 ? 'multiple="multiple"' : ''); }
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
		
		printf('<option %s value="%s" %s>%s</option>', $extra, $value, $selected ? 'selected="selected"' : '', $name);
	}
	
	public static function checkbox(field $field, $extra = '')
	{
		$checked = in_array($value, explode(',', $field->value));
		printf('<input type="checkbox" %s name="%s[]" value="1" %s />', $extra, $field->name, $checked ? 'checked="checked"' : '');
	}

	public static function dop($i, $s) { foreach(explode(',', $s) as $k) $i[$k]->post(); }
	
	public static function form_start($controller, $function = 'post', $parameters = array(), $extra = '') { printf('<form action="%s" method="post" enctype="multipart/form-data" %s>', util::href($controller, $function, $parameters), $extra); }
	public static function form_end() { printf('</form>'); }
}

?>