<?php
require_once(dirname(__FILE__) . "/db.class.php");
require_once(dirname(__FILE__) . "/conversation.class.php");

/**
 * 
 */
class Message{
	public $id;
	public $id_conversation;
	public $from_uid;
	public $message;
	
	function __construct() {
		
	}
	
	public static function createMessage($conv_id, $poster, $content){
		$message = new Message();
		
		$message->id_conversation  = $conv_id;
		$message->from_uid = $poster;
		$message->message = $content;
		
		return $message;
	}
	
	public static function getMessageById($id){
		$db = new db();
		
		$query = $db->prepare("SELECT `id_message`, `id_conversation`, `from_uid`, `message` FROM `message` WHERE `id_message` = ?");
		
		try{
			$query->execute(array($id));
			
			if($query->rowCount() != 1)
				return null;
			
			$res = $query->fetch(PDO::FETCH_ASSOC);
			$message = new Message();
			$message->id  = $res['id_message'];
			$message->id_conversation  = $res['id_conversation'];
			$message->from_uid = $res['from_uid'];
			$message->message = $res['message'];
			
			return $message;
		}catch(PDOException $e){
			echo json_encode(array("error", $e->getError()));
			return null;
		}
	}
	
	/**
	 * Envoie le message précédemment créé
	 */	
	public function addMessage() {
		return Conversation::addMessage($this);		
	}
}
