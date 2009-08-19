<?php
/**
 * index.php
 * 
 * This entry point file is the homepage for the MSC Assets system.
 * 
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @package MSC Assets
 * 
 */

define('_MSC', true);

/**
 * bring in the configuration
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/config.php');

/**
 * bring in the library
 */
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/library.php');


/**
 * call output buffering strictly for performance benefits. all output should 
 */
ob_start('');

/**
 * @todo check for login
 */

$page['title'] = 'Front Page';
$skin->output();

?>