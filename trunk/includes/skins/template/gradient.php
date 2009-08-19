<?php
/**
 * includes/skins/template/gradient.php
 * 
 * Thanks to the valuable class by Ozh (gradient.class.php) this file, when called,
 * outputs a PNG gradient with the given parameters. It should be called directly
 * from the browser as an image with the optional GET variables:
 *   height, width, start, end, type
 * 
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @package MSC Assets
 * 
 */

/**
 * make this a valid code entry point
 */
define('_MSC', 1);


/**
 * bring in the library, specifically so we can use color calculations
 */
require_once('../../library.php');


/**
 * Determine the width of the gradient image
 * @var int
 */
if (empty($_GET['width']) || $_GET['width'] != (int)$_GET['width'])
	$width = 10;
else
	$width = $_GET['width'];


/**
 * Determine the height of the gradient image
 * @var int
 */
if (empty($_GET['height']) || $_GET['height'] != (int)$_GET['height'])
	$height = 10;
else
	$height = $_GET['height'];


/**
 * Determine the starting color of the gradient image
 * @var string
 */
if (empty($_GET['start']) || !preg_match('/^[0-9a-f][0-9a-f][0-9a-f]([0-9a-f][0-9a-f][0-9a-f])?$/i', $_GET['start']))
	$start = 'ffffff';
else
	$start = $_GET['start'];
$start = color_prepare($start);


/**
 * Determine the ending color of the gradient image
 * @var int
 */
if (empty($_GET['end']) || !preg_match('/^[0-9a-f][0-9a-f][0-9a-f]([0-9a-f][0-9a-f][0-9a-f])?$/i', $_GET['start']))
{
	if (is_bright($start))
		$end = color_darken($start, 80);
	else
		$end = color_lighten($start, 80);
}
else
	$end= $_GET['end'];
$end = color_prepare($end);

/**
 * see if we need to swap the colors
 */
if (!empty($_GET['reverse']))
{
	$tmp = $end;
	$end = $start;
	$start = $tmp;
	unset($tmp);
}
/**
 * define the allowed types, just for ease of use
 */
$allowed = array('vertical', 'horizontal', 'rectangle', 'ellipse', 'ellipse2', 'circle', 'circle2', 'diamond');


/**
 * Determine the type of gradient we're generating
 * @var string
 */
if (empty($_GET['type']) || !in_array($_GET['type'], $allowed))
	$type = 'rectangle';
else
	$type = $_GET['type'];

//echo 'here';die("$width,$height,$type,$start,$end");
require_once('gradient.class.php');
$image = new gd_gradient_fill($width,$height,$type,$start,$end);
header('Content-type: image/png');
imagepng($image);

 ?>