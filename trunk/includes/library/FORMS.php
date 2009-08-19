<?php
/**
 * includes/library/DB.php
 * 
 * This file houses the db class, which is used for MySQL database handling.
 * 
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @package MSC Assets
 * 
 */

defined('_MSC') or die('Unauthorized');
$debug->log("Form class initiating...");

/**
 * The form class generates HTML form elements in a consistent, simple manner
 */
class form
{
	
	/**
	 * This function generates a checkbox along with its label.
	 * @return string containing checkbox field HTML
	 * @param object $label - string containing the field's label
	 * @param object $name - string containing the field's name (also its ID)
	 * @param object $checked[optional] - boolean value for if the box should be pre-checked
	 * @param object $attributes[optional] - array containing any special attributes to apply (onchange, tabindex, etc.)
	 * @param object $details[optional] - string containing any post-field details (tips, etc.)
	 */
	public function checkbox($label, $name, $checked = false, $attributes = null, $details = null)
	{
		$ret = $this->_label($label, $name); // generate the label
		$ret .= "<input type='checkbox' name='$name' id='$name'";
		if ($checked)
			$ret .= " checked='checked'";
		if (!empty($attributes)) // see if there are custom attributes
		{
			foreach ($attributes as $key => $value)
			{
				if ($key != 'type' && $key != 'name' && $key != 'id' && $key != 'value')
					$ret .= " $key='" . $value . "'";
			}
		}
		$ret .= "/>";
		if (!empty($details))
			$ret .= " <span class='details'>" . $details . "</span>";
		$ret .= "<br/>\n"; // close it off and line break
		return $ret;
	}

	
	
	/**
	 * This function generates a password field along with its label.
	 * @return string containing password field HTML
	 * @param object $label - string containing the field's label
	 * @param object $name - string containing the name of the field (also its ID)
	 * @param object $attributes[optional] - array containing any special attributes to apply (onchange, tabindex, etc.)
	 * @param object $details[optional] - string containing any post-field details (tips, etc.)
	 */
	public function password($label, $name, $attributes = null, $details = null)
	{
		$ret = $this->_label($label, $name); // generate the label
		$ret .= "<input type='text' name='$name' id='$name'";
		if (!empty($attributes)) // see if there are custom attributes
		{
			foreach ($attributes as $key => $value)
			{
				if ($key != 'type' && $key != 'name' && $key != 'id' && $key != 'value')
					$ret .= " $key='" . $value . "'";
			}
		}
		$ret .= "/>";
		if (!empty($details))
			$ret .= " <span class='details'>" . $details . "</span>";
		$ret .= "<br/>\n"; // close it off and line break
		return $ret;
	}
	
	
	/**
	 * This function generates a text box along with its label.
	 * @return string containing text field HTML
	 * @param object $label - string containing the field's label
	 * @param object $name - string containing the name of the field (also its ID)
	 * @param object $value[optional] - string continaing the pre-set value of the field
	 * @param object $attributes[optional] - array containing any special attributes to apply (onchange, tabindex, etc.)
	 * @param object $details[optional] - string containing any post-field details (tips, etc.)
	 */
	public function text($label, $name, $value = null, $attributes = null, $details = null)
	{
		$ret = $this->_label($label, $name); // generate the label
		$ret .= "<input type='text' name='$name' id='$name' value='" . htmlentities($value, ENT_QUOTES) . "'";
		if (!empty($attributes)) // see if there are custom attributes
		{
			foreach ($attributes as $key => $value)
			{
				if ($key != 'type' && $key != 'name' && $key != 'id' && $key != 'value')
					$ret .= " $key='" . $value . "'";
			}
		}
		$ret .= "/>";
		if (!empty($details))
			$ret .= " <span class='details'>" . $details . "</span>";
		$ret .= "<br/>\n"; // close it off and line break
		return $ret;
	}
	
	/**
	 * This function generates a select box, along with its label, and preselected value.
	 * @return string containing SELECT element and OPTIONS
	 * @param object $label - string containing the field's label
	 * @param object $name - string containing the name of the field (also its ID)
	 * @param object $options - key/value array containing select's options, with value optionally being an array with html attributes (the option's text should have a key of 'text')
	 * @param object $selected[optional] - string containing the pre-selected value
	 * @param object $attributes[optional] - array containing additional attributes to be applied to the select (onchange, for example)
	 * @param object $details[optional] - string containing any post-field details (tips, etc.)
	 */
	public function select($label, $name, $options, $selected = null, $attributes = null, $details = null)
	{
		$ret = $this->_label($label, $name); // generate the label
		$ret .= "<select name='$name' id='$name'"; // begin the SELECT html
		if (!empty($attributes) && is_array($attributes)) // determine if we're adding any other attributes
		{
			foreach ($attributes as $key => $value)
			{
				$ret .= " $key='$value'";
			}
		}
		$ret .= ">\n"; // close the opening <select>
		foreach ($options as $key => $value)
		{
			$attributes = array(); // just reuse this variable, since we're done with it anyway
			if (is_array($value)) // determine if we should parse out per-option attributes
			{
				foreach ($value as $foo => $bar)
				{
					if ($foo == 'text')
						$val = $bar;
					else
						$attributes[$foo] = $bar;
				}
				if (!empty($val))
					$value = $val;
				else
					$value = '!!!ERROR!!!'; // this shouldn't happen unless a coder made an oops
			}
			$ret .= "<option value='$key'";
			foreach ($attributes as $foo => $bar)
			{
				if ($foo != 'value' && $foo != 'selected')
					$ret .= " $foo='$bar'";
			}
			if (!empty($selected) && $selected == $key)
				$ret .= " selected='selected'";
			$ret .= ">" . $value . "</option>";
		}
		$ret .= "</select>";
		if (!empty($details))
			$ret .= " <span class='details'>" . $details . "</span>";
		$ret .= "<br/>\n"; // close the select and clean line break
		return $ret;
	}



	/**
	 * Internal function that generates a field label.
	 * @return 
	 * @param object $label
	 * @param object $for[optional]
	 */
	private function _label(string $label, $for = null)
	{
		$ret = "<label";
		if (!empty($for))
			$ret .= " for='$for'";

		$ret .= ">$label</label>";
		return $ret;
	}
}


$form = new form;


?>