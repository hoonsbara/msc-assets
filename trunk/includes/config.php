<?php
/**
 * includes/config.php
 * 
 * This file contains the basic configuration that varies with each installation
 * of MSC Assets.
 * 
 * @todo make a configuration tool that rebuilds the config file, to be auto-run if config.php doesn't exist
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @package MSC Assets
 * 
 */

defined('_MSC') or die('Unauthorized');

$config = array
(
	'site_title'	=>	'MSC Assets',
	'mysql' => array
	(
		'username'	=>	'assets',
		'password'	=>	'123567890',
		'database'	=>	'assets',
		'hostname'	=>	'localhost',
	),
  
);

?>