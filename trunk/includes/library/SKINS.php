<?php
/**
 * includes/library/SKINS.php
 * 
 * Contains the functions that recognize and apply the user's skin choice
 * 
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @package MSC Assets
 * 
 */
defined('_MSC') or die('Unauthorized');
$debug->log("Skin class initiating...");


class skin 
{
	public $name = null;
	public function discover()
	{
		/**
		* @todo have actual per-interface/user skin logic rather than statically defining it
		*/ 
		if (empty($this->name))
		{
			$this->name = 'template';
		}
	}

	function output()
	{
		global $page, $config;
		$this->discover(); // make sure we have the skin defined
		$path = $_SERVER['DOCUMENT_ROOT'] . '/includes/skins/' . $this->name . '.html';
		$html = file_get_contents($path);
		$search = array
		(
			'(%SITE_TITLE%)',
			'(%PAGE_TITLE%)',
			'(%CONTENT%)',
		);
		$replace = array
		(
			$config['site_title'],
			empty($page['title']) ? 'UNTITLED PAGE' : $page['title'],
			$page['content'],
		);
		echo str_replace($search, $replace, $html);
	}

	
}

$skin = new skin;


?>