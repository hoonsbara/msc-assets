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
$debug->log("Database class initiating...");

/**
 * The db class connects to the database and handles all the queries 
 * against it.
 */
class db
{
	/**
	 * Internally stores the hostname used for accessing MySQL.
	 * @var string
	 */
	private $_mysql_host;

	/**
	 * Internally stores the username used for accessing MySQL.
	 * @var string
	 */
	private $_mysql_user;

	/**
	 * Internally stores the password used for accessing MySQL.
	 * @var string
	 */
	private $_mysql_pass;

	/**
	 * Internally stores the name of the MySQL database MSC Assets uses.
	 * @var string
	 */
	private $_mysql_base;
	
	/**
	 * Internally stores the MySQL connection.
	 * @var resource
	 */
	private $_mysql_link;
	
	/**
	 * Contains statistics relating to the MySQL query runtimes, etc.
	 * @var array
	 */
	public $stats = array();
 
 	/**
 	 * constructor - Establishes the MySQL connection and selects the database.
 	 * @return bool
 	 */
	public function db()
	{
		if ($this->_mysql_link)
			return true;
		else
		{
			global $debug;
			global $config;
			$this->_mysql_host = $config['mysql']['hostname'];
			$this->_mysql_user = $config['mysql']['username'];
			$this->_mysql_pass = $config['mysql']['password'];
			$this->_mysql_base = $config['mysql']['database'];
			unset($config['mysql']); // purge this info, since it's privatized now
						
			if ($this->_mysql_link = mysql_connect($this->_mysql_host, $this->_mysql_user, $this->_mysql_pass))
			{
				$debug->log('Successfully connected to MySQL @ ' . $this->_mysql_host);
				return mysql_select_db($this->_mysql_base);
			}
			else
			{
				$debug->log('Could not connect to MySQL @ ' . $this->_mysql_host . ' (' . $this->_mysql_user . ':*****)');
				$debug->log(mysql_error());
				return false;
			}
		}
	}
	
	/**
	 * Internal function used to kill a script that experiences a MySQL error
	 * before any more damage is done.
	 * @return void
	 * @param object $query string
	 * @param object $error string
	 */
	private function _error ($query, $error)
	{
		global $debug;
		$debug->log("Database Error:\n" . $query . "\n" . $error);
		die;
	}
	
	/**
	 * Runs the given query against the connected database, recording statistics along the way.
	 * @return mixed
	 * @param object $query
	 */
	public function query ($query)
	{
		$timer = microtime();
		if (!($result = mysql_query($query, $this->_mysql_link)))
		{
			$this->_error($query, mysql_error());
			return $result;
		}
		$timer = microtime() - $timer;
		
		$tmp = explode(' ', $query);
		$tmp = $tmp[1];
		$tmp = strtoupper($tmp);
		
		if (empty($this->stats[$tmp]))
			$this->stats[$tmp] = $timer;
		else
			$this->stats[$tmp] += $timer;
		return $result;
	}

	/**
	 * Runs the provided query against the database, returning the string
	 * found in the first column, first row of results.
	 * @return string
	 * @param object $query
	 */
	public function str($query)
	{
		$result = $this->query($query);
		$tmp = mysql_fetch_row($result);
		mysql_free_result($result);
		return $tmp[0];
	}

	/**
	 * Runs the provided query against the database, returning an array
	 * of the first row of results.
	 * @return array
	 * @param object $query
	 */
	public function sng($query)
	{
		$result = $this->query($query);
		$tmp = mysql_fetch_array($result, MYSQL_ASSOC);
		mysql_free_result($result);
		return $tmp;
	}

	/**
	 * Runs the provided query against the database, returning a two-dimensional
	 * (key => value) array of the first two columns in the results (note that
	 * keys might overwrite each other if not unique).
	 * @return array
	 * @param object $query
	 */
	public function lst($query)
	{
		$tmp = array();
		$result = $this->query($query);
		while ($line = mysql_fetch_row($result))
		{
			$tmp[$line[0]] = $line[1]; // first item is treated as the key
		}
		return $tmp;
	}

	/**
	 * Runs the provided query against the database, returning a three-dimensional
	 * (key => value_array) array of the results (note that keys might overwrite
	 * each other if not unique).
	 * @return array
	 * @param object $query
	 * @param object $key[optional]
	 */
	public function arr($query, $key = NULL)
	{
		$tmp = array();
		$result = $this->query($query);
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			if (!empty($key) && !empty($line[$key]) && $line[$key] !== 0)
				$tmp[$line[$key]] = $line;
			else
				$tmp[] = $line;
		}
		return $tmp;	

	}
	
	/**
	 * Returns results in an associative array like $this->arr(), but offers two
	 * 'key' arguments that can group the array into sub-arrays.
	 * @return array
	 * @param object $query
	 * @param object $key1
	 * @param object $key2
	 */
	public function two($query, $key1, $key2)
	{
		$tmp = array();
		$result = $this->query($query);
		while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$tmp[$line[$key1]][$line[$key2]] = $line;
		}
		return $tmp;
	}

}

/**
 * Escapes and prepares a string for safe interaction with MySQL. All non-hard-coded
 * values (dynamic variables, user input, etc.) should go through this function before
 * ever touching MySQL (regardless of the query type [SELECT, UPDATE, INSERT, etc.]).
 * @return string
 * @param object $string
 */
function db_prepare($string)
{
	$return = trim($string);
	$return = stripslashes($return);
	$return = mysql_real_escape_string($return);
	return $return;
}


/**
 * Initiate the db class and connect to the database.
 * @var db
 */
$db = new db;

?>