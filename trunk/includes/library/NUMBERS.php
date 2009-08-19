<?php
/**
 * includes/library/NUMBERS.php
 * 
 * Contains a variety of mathmatical functions
 * 
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @package MSC Assets
 * @todo clean this up into a class
 * 
 */
defined('_MSC') or die('Unauthorized');
$debug->log("Number library initiating...");


/**
 * generates the percentage value for the represented part/whole
 * @return string containing percentage value
 * @param object $part the smaller number
 * @param object $whole the bigger number
 * @param object $decimal[optional] number of decimal places
 */
function percent ($part, $whole, $decimal = 0)
{
	return round(($part / $whole) * 100, $decimal) . '%';
}


/**
 * strips out non-numbers from a string
 * @return integer
 * @param object $number
 */
function number_cleanup ($number)
{
	return (int)preg_replace('/[^0-9]/', $number);
}

?>