<?php

defined('_MSC') or die('Unauthorized');

/**
 * This class handles debug output and logging throughout the application.
 */
class debug
{
	/**
	 * Contains the full history of the debug log.
	 * @var array
	 */
	public $history = array();

	/**
	 * Contains the content of the current debug log entry
	 * @var mixed
	 */
	private $_content;
	
	/**
	 * set at the beginning of the run, defining whether the app is in debug mode
	 * @var bool
	 */
	private $_enabled;
	
	/**
	 * constructor - sets the _enabled setting
	 * @return void
	 */
	function debug()
	{
		// determine if debugging is enabled
		global $config;
		if (!empty($config['debug']))
		  $this->_enabled = 1;
		else
		  $this->_enabled = 0;	 
	}
	
	/**
	 * Logs (and if debug mode is on, displays) the given content, which can be a string or an array
	 * @return void
	 * @param object $content
	 */
	public function log($content)
	{
		$this->_content = $content;
		$this->_prepare();
		if ($this->_enabled)
		{
			$this->display(1);
		}
		//echo "\n--HERE-- $content\n";
		$this->_history[] = $this->_content;
	}
	
	/**
	 * Internal function for capturing the current time stamp with milliseconds
	 * @return string
	 */
    private function _time()
    {
      $utimestamp = microtime(true);
      $timestamp = floor($utimestamp);
      $milliseconds = round(($utimestamp - $timestamp) * 1000000);

      return date('Y-m-d h:i:s') . '.' . $milliseconds;
    }

	/**
	 * Internal function that provides consistent formatting for debug content. it print_r()s arrays, specifically
	 * @return void
	 */
	private function _prepare()
	{
		if (is_array($this->_content))
		{
			$this->_content = print_r($this->_content, 1);
		}
		$this->_content = 'DEBUG @ ' . $this->_time() . ' - ' . $this->_content . "\n";
	}
	
	/**
	 * Displays the most recent log content, with an option to bypass _prepare().
	 * 
	 * @return void
	 * @param object $logged[optional] bool
	 */
	public function display($logged = false)
	{
		if (!$logged)
		{
			$this->_prepare();
		}
		echo $this->_content;
	}
	
	/**
	 * Dumps the entire debug log, optionally within a PRE element.
	 * 
	 * @return void
	 * @param object $pre[optional] bool
	 */
	public function dump($pre = 0)
	{
		if ($pre)
		{
			echo "<pre>\n";
		}
		echo "\n\n-----DEBUG LOG DUMP BEGIN------\n";
		foreach ($this->_history as $line)
		{
			echo htmlentities($line);
		}
		echo "\n-----DEBUG LOG DUMP END------\n\n";
		if ($pre)
		{
			echo "</pre>\n";
		}
	}
}

/**
 * $debug contains the debug class and all relevant data
 * @var debug
 */
$debug = new debug;

?>