<?php
require_once(dirname(__FILE__) . "/../config.inc.php");

/**
 * 
 */
class db extends PDO{
	/**
	 * Ouvre la base de données. Si la base n'existe pas elle
	 * est créée à l'aide de la méthode createDataBase().
	 */
	public function __construct() {
		parent::__construct('mysql:host='._DB_HOST_.';dbname='._DB_DBNAME_, _DB_USERNAME_, _DB_PASSWD_);
	}
}
	
?>