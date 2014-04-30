<?php
require_once(dirname(__FILE__) . "/db.class.php");

/**
 * 
 */
class Conversation{
	public $id;
	public $closed;
	
	function __construct(){}
	
	public static function getConversationById($id){
		$db = new db();
		$query = $db->prepare("SELECT * FROM `conversation` WHERE `id_conversation` = ?");
		
		try{
			$query->execute(array($id));
			
			if($query->rowCount() != 1){
				$res = $query->fetch(PDO::FETCH_ASSOC);
				
				$conv = new Conversation();
				$conv->id = $res['id_conversation'];
				$conv->closed = ($res['closed'] != 0);
				
			}else{
				return null;
			}
			
		}catch(PDOException $e){
			echo json_encode(array("error", $e->getError()));
			return null;
		}
	}
	
	public static function createConversation(){
		return new Conversation();
	}
	
	public function addConversation() {
		$db = new db();
		$query = $db->prepare("INSERT INTO `conversation`(`closed`) VALUES (0)");
		if ($query===false)
			return false;
		
		try{
			$query->execute();
		}catch(PDOException $e){
			echo json_encode(array("error", $e->getError()));
			return false;
		}
		
		$this->id = $db->lastInsertId();
		return true;
	}
	
	/**
	 * Ajoute un utilisateur à la conversation
	 */
	public function subscribeUser($uid) {
		$db = new db();
		$query = $db->prepare("INSERT INTO `conversation_subscribe`(`id_conversation`, `uid`) VALUES (?,?)");
		$verifquery = $db->prepare("SELECT * FROM `conversation_subscribe` 
			WHERE `id_conversation` = ? AND `uid` = ?");
		if ($query===false)
			return false;
		
		try{
			$verifquery->execute(array($this->id, $uid));
				if($verifquery->rowCount() == 0)
					$query->execute(array($this->id, $uid));
		}catch(PDOException $e){
			echo json_encode(array("error", $e->getError()));
			return false;
		}
		
		return true;
	}
	
	/**
	 * Ajoute un utilisateur à la conversation
	 * @param $uids array int tableau contenant les UID des utilisateurs à ajouter.
	 */
	public function subscribeUsers($uids) {
		$db = new db();
		$query = $db->prepare("INSERT INTO `conversation_subscribe`(`id_conversation`, `uid`) VALUES (?,?)");
		$verifquery = $db->prepare("SELECT * FROM `conversation_subscribe` 
			WHERE `id_conversation` = ? AND `uid` = ?");
		if ($query===false)
			return false;
		
		try{
			
			foreach($uids as $uid){
				$verifquery->execute(array($this->id, $uid));
				if($verifquery->rowCount() == 0)
					$query->execute(array($this->id, $uid));
			}
		}catch(PDOException $e){
			echo json_encode(array("error", $e->getError()));
			return false;
		}
		
		return true;
	}
	
	/**
	 * chaque utilisateur peut se retirer d'une conversation */
	public function unsubscribeUser($uid) {
		// un get pour récupérer l'id de l'utilisateur ou alors le passer en argument
		$db = new db();
		$request = $db->prepare("DELETE FROM conversation_subscribe WHERE id_conversation = ? AND uid = ?;");
		if ($request===false) return false;
		
		try{
			$request->execute(array($this->id, $uid));
		}catch(PDOException $e){
			echo json_encode(array("error", $e->getError()));
			return false;
		}
		return true;
	}
	
	/**
	 * 
	 */
	public function getSubscribers(){
		$db = new db();
		$request = $db->prepare("SELECT `uid` FROM `conversation_subscribe` WHERE `id_conversation` = ?");
		if ($request===false) return false;
		
		try{
			$request->execute(array($this->id));
			return $request->fetchAll(PDO::FETCH_ASSOC);
		}catch(PDOException $e){
			echo json_encode(array("error", $e->getError()));
			return null;
		}
		return null;
	}
	
	
	/**
	 * s'il reste 0 personnes, supprimer la conversation
	 **/
	public function isThereStillPeopleInConversation() {
		$request = $this->connection->prepare("SELECT uid from CONVERSATION_SUBSCRIBE where id_conversation = ?;");
		if ($request===false) return false;
		if (!$request->execute(array($id_conversation))) return false;
		
		if($request->rowCount()===0) {
			$request = $this->connection->prepare('UPDATE CONVERSATION set closed = ?;'); /* mettre 1 directement ici ? */

			$query = $request->execute(array(1));
			if (!$query) {
	   			 echo "\n*** PDO: Erreur MySQL *** \n";
		         print_r($this->connection->errorInfo());
		         return false;
		    }
		}
		else return $request->rowCount();
	}
	
	
	public function getMessages(){
		$db = new db();
		$request = $db->prepare("SELECT `id_message`, `from_uid`, `message` FROM `message` WHERE `id_conversation` = ?");
		if ($request===false) return false;
		
		try{
			$request->execute(array($this->id));
			return $request->fetchAll(PDO::FETCH_ASSOC);
		}catch(PDOException $e){
			echo json_encode(array("error", $e->getError()));
			return null;
		}
		return null;
	}
	
	public function addMessage($message){
		$db = new db();
		$query = $db->prepare("INSERT INTO `message`(`id_conversation`, `from_uid`, `message`) VALUES (?, ?, ?)");
		
		try{
			$query->execute(array($message->id_conversation, $message->from_uid, $message->message));
			$message->id = $db->lastInsertId();
			return true;
			
		}catch(PDOException $e){
			echo json_encode(array("error", $e->getError()));
			return false;
		}
	}
	
	
	/** 
	 * si closed = 1, supprimer la conversation
	 * du coup, c'est soit on garde cette fonction, soit on met juste closed à 1 pour conserver une archive
	 */
	public function deleteConversation($id_conversation) {
		$request = $this->connection->prepare("DELETE * from CONVERSATION where id_conversation = ?;");
		if ($request===false) return false;
		if (!$request->execute(array($id_conversation))) return false;
		return true;
	}
	
	public function getId(){return $this->id;}
}

?>