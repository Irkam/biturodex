<?php

class Conversation{
	public $id;
	
	public function addConversation($closed) {
		/*
		$this->connection->exec("CREATE TABLE IF NOT EXISTS conversation(id_conversation integer primary key auto_increment, 
																	     closed boolean
																	    )");
		*/
		$query = $this->connection->prepare("INSERT INTO conversation($closed) VALUES (?)");
		if ($query===false) { $this->connection->rollback(); return false; }
		$res = $query->execute(array($closed));
		if ($res === false) { $this->connection->rollback(); return false; }
	}
	
	/**
	 * Ajoute un utilisateur à la conversation
	 */
	public function addUserToConversation($uid) {
		$query = $this->connection->prepare("INSERT INTO conversation_subscribe($this->id, $uid) VALUES (?,?)");
		if ($query===false) { $this->connection->rollback(); return false; }
		$res = $query->execute(array($this->id, $uid));
		if ($res === false) { $this->connection->rollback(); return false; }
	}
	
	/**
	 * chaque utilisateur peut se retirer d'une conversation */
	public function unsubscribeUser($id_conversation) {
		// un get pour récupérer l'id de l'utilisateur ou alors le passer en argument
		$request = $this->connection->prepare("SELECT uid from CONVERSATION_SUBSCRIBE where id_conversation = ?;");
		if ($request===false) return false;
		if (!$request->execute(array($id_conversation))) return false;
		
		$heDoesNotWantToChatAnymore = $request;
		//if($heDoesNotWantToChatAnymore)
	}
	
	
	/**
	 * s'il reste 0 personnes, supprimer la conversation
	 **/
	public function isThereStillPeopleInConversation($id_conversation) {
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
}

?>