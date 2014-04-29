<?php
require_once(dirname(__FILE__) . "/db.class.php");

/**
 * 
 */
class Message{
	public $id;
	public $conv_id;
	public $content;
	
	function __construct($argument) {
		
	}
	
	/**
	 * Envoie le message précédemment créé
	 */	
	public function addMessage($id_conversation, $from_uid, $message) {
		/*
		$this->connection->exec("CREATE TABLE IF NOT EXISTS message(id_message integer primary key auto_increment, 
																	id_conversation integer, 
																	from_uid integer, 
																	message char(4096)
																   )");
		*/
		$query = $this->connection->prepare("INSERT INTO message($id_conversation, $from_uid, $message) VALUES (?,?,?)");
		if ($query===false) { $this->connection->rollback(); return false; }
		$res = $query->execute(array($id_conversation, $from_uid, $message));
		if ($res === false) { $this->connection->rollback(); return false; }
		
	}
}
