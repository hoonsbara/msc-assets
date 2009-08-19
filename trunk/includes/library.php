<?php
/**
 * includes/library.php
 * 
 * This file calls in all the various files containing function libraries
 * and classes used in MSC Assets.
 * 
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @package MSC Assets
 * 
 */

defined('_MSC') or die('Unauthorized');


/**
 * Always bring in the debug class first, since almost every other library
 * calls on it.
 */
require $_SERVER['DOCUMENT_ROOT'] . '/includes/library/DEBUG.php';


/**
 * It's not a bad idea to always bring in the database class second, since
 * so many things will interact with the database.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/library/DB.php';


/**
 * The forms class creates form element html easily and consistently.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/library/FORMS.php';


/**
 * For all our math calculations and numerical operations...
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/library/NUMBERS.php';


/**
 * For all our color calculations...
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/library/COLORS.php';


/**
 * For skin recognition and display
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/library/SKINS.php';

?>