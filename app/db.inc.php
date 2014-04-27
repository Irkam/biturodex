<?
class Database {

	private $connection;

	/**
	 * Ouvre la base de données. Si la base n'existe pas elle
	 * est créée à l'aide de la méthode createDataBase().
	 */
	public function __construct() {
		$dbHost = $_SERVER['dbHost'];
		$dbBd = $_SERVER['dbBd'];
		$dbPass = $_SERVER['dbPass'];
		$dbLogin = $_SERVER['dbLogin'];
		/*$dbHost = 'localhost';
		$dbBd = 'dbBd';
		$dbPass = '';
		$dbLogin = 'root';*/
		$url = 'mysql:host='.$dbHost.';dbname='.$dbBd;
		//$url = 'sqlite:database.sqlite';
		$this->connection = new PDO($url, $dbLogin, $dbPass);
		if (!$this->connection) die("impossible d'ouvrir la base de données");
	}
	
	/**
	 * Vérifie si un pseudonyme est valide, c'est-à-dire,
	 * s'il contient entre 3 et 60 caractères et uniquement des lettres.
	 *
	 * @param string $username Pseudonyme à vérifier.
	 * @return boolean true si le pseudonyme est valide, false sinon.
	 */
	private function checkUsernameValidity($username) {
		$usernameLength = strlen($username); 
		if($usernameLength < 3 || $usernameLength > 60)
			return false;
		return ctype_alpha($username);

	}

	/**
	 * Vérifie si un mot de passe est valide, c'est-à-dire,
	 * s'il contient entre 3 et 256 caractères.
	 * 
	 * @param string $password Mot de passe à vérifier.
	 * @return boolean true si le mot de passe est valide, false sinon.
	 */
	private function checkPasswordValidity($password) {
		$passwordLength = strlen($password); 
		return $passwordLength >= 3 && $passwordLength <= 256;
	}

	/**
	 * Vérifie la disponibilité d'un pseudonyme.
	 *
	 * @param string $username Pseudonyme à vérifier.
	 * @return boolean true si le pseudonyme est disponible, false sinon.
	 */
	private function checkUsernameAvailability($username) {
		$request = $this->connection->prepare("select username from user where nickname = ?;");
		if ($request===false) return false;
		if (!$request->execute(array($newNickname))) return false;
		return $request->rowCount()===0;
	}
	
	/**
	 * Vérifie qu'un couple (pseudonyme, mot de passe) est correct.
	 *
	 * @param string $username Pseudonyme.
	 * @param string $password Mot de passe.
	 * @return boolean true si le couple est correct, false sinon.
	 */
	public function checkPassword($username, $password) {
		$request = $this->connection->prepare("select * from users username where username = ? and password = ?");
		if ($request===false) return false;
		if(!$request->execute(array($username, $password))) return false;
		return $request->rowCount()===1;
	}

	/**
	 * Ajoute un nouveau compte utilisateur si le pseudonyme est valide et disponible et
	 * si le mot de passe est valide. La méthode peut retourner un des messages d'erreur qui suivent :
	 * - "Le pseudo doit contenir entre 3 et 30 lettres.";
	 * - "Le mot de passe doit contenir entre 3 et 256 caractères.";
	 * - "Le pseudo existe déjà.".
	 *
	 * @param string $username Pseudonyme.
	 * @param string $password Mot de passe.
	 * @return boolean|string true si le couple a été ajouté avec succès, un message d'erreur sinon.
	 */
	public function addUser($username, $password) {
	
		/*$this->connection->exec("CREATE TABLE IF NOT EXISTS user(uid integer primary key auto_increment, 
																 name char(30), 
																 firstname char(50)
																 username char(60), 
																 mailaddress char(64), 
																 password char(256),
																 sesstoken char(60), 
																 pushtoken char(60), 
																 latitude double, 
																 longitude double
																)");
		*/														
	
	  	if(!$this->checkUsernameValidity($username))
	  		return "Le pseudo doit contenir entre 3 et 60 lettres.";
	  		
	  	if(!$this->checkPasswordValidity($password))
	  		return "Le mot de passe doit contenir entre 3 et 256 caractères";
	  		
	  	if(!$this->checkUsernameAvailability($username))
	  		return "Le pseudo existe déjà";
	  	
	  	$request = $this->connection->prepare('INSERT INTO user(name, firstname, username, mailaddress, password, sesstoken, pushtoken, latitude, longitude) VALUES (?,?,?,?,?,?,?,?,?)');
	  	
		$res = $request->execute(array($name, $firstname, $username, $mailaddress, $password, $sesstoken, $pushtoken, $latitude, $longitude));
	  	if(!$res) return "Couldn't add user";
	  	return true;
	}

	/**
	 * Change le mot de passe d'un utilisateur.
	 * La fonction vérifie si le mot de passe est valide. S'il ne l'est pas,
	 * la fonction retourne le texte 'Le mot de passe doit contenir entre 3 et 256 caractères.'.
	 * Sinon, le mot de passe est modifié en base de données et la fonction retourne true.
	 *
	 * @param string $username Pseudonyme de l'utilisateur.
	 * @param string $password Nouveau mot de passe.
	 * @return boolean|string True si le mot de passe a été modifié, un message d'erreur sinon.
	 
	 
	 NON ADAPTÉ
	 */
	public function updateUser($username, $password) {
		if(!$this->checkPasswordValidity($password))
	  		return "Le mot de passe doit contenir entre 3 et 256 caractères";

		$request = $this->connection->prepare('update user set password = ? where username = ?;');
		
		$query = $request->execute(array($password,$username));
		if (!$query) {
   			 echo "\n*** PDO: Erreur MySQL *** \n";
             print_r($this->connection->errorInfo());
             return false;
        }
		
	 	return true;
	}
	
/** ce qui est au dessus fonctionne NORMALEMENT */
	
	/* */
	public function addEvent($name, $own_uid, $id_establishment, $latitude, $longitude, $radius, $begins, $ends, $id_type, $address) {
		/* $this->connection->beginTransaction(); */
		
		/*
		$this->connection->exec("CREATE TABLE IF NOT EXISTS event(id_event integer primary key auto_increment, 
																  name char(64), 
																  owner_uid integer, 
																  id_establishment integer, 
																  latitude double, 
																  longitude double, 
																  radius int, 
																  begins datetime, 
																  ends datetime, 
																  id_type integer, 
																  address char(250), 
																 )");
		*/
		
		/* ici, les fonctions de vérification de la validité du contenu des variables */
		$query = $this->connection->prepare("INSERT INTO event(name, own_uid, id_establishment, latitude, longitude, radius, begins, ends, id_type, address) VALUES (?,?,?,?,?,?,?,?,?,?)");
		if ($query===false) { $this->connection->rollback(); return false; }
		$res = $query->execute(array($name, $own_uid, $id_establishment, $latitude, $longitude, $radius, $begins, $ends, $id_type, $address));
		if ($res === false) { $this->connection->rollback(); return false; }
	}
	
	/* */
	public function addEstablishment($id_type, $name, $address0, $address2, $city, $postcode, $latitude, $longitude) {
		/*
		$this->connection->exec("CREATE TABLE IF NOT EXISTS establishment(id_establishment integer primary key auto_increment, 
																		  id_type integer, 
																		  name char(60), 
																		  address0 char(60), 
																		  address2 char(60), 
																		  city char(30), 
																		  postcode char(6), 
																		  latitude double, 
																		  longitude double
																		 )");
		*/
		$query = $this->connection->prepare("INSERT INTO establishment($id_type, $name, $address0, $address2, $city, $postcode, $latitude, $longitude) VALUES (?,?,?,?,?,?,?,?)");
		if ($query===false) { $this->connection->rollback(); return false; }
		$res = $query->execute(array($id_type, $name, $address0, $address2, $city, $postcode, $latitude, $longitude));
		if ($res === false) { $this->connection->rollback(); return false; }
	}
	
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
	
	public function addUserToConversation($id_conversation, $uid) {
		$query = $this->connection->prepare("INSERT INTO conversation_subscribe($id_conversation, $uid) VALUES (?,?)");
		if ($query===false) { $this->connection->rollback(); return false; }
		$res = $query->execute(array($id_conversation, $uid));
		if ($res === false) { $this->connection->rollback(); return false; }
	}
	
	/* chaque utilisateur peut se retirer d'une conversation */
	public function removeMyselfFromConversation($id_conversation) {
		// un get pour récupérer l'id de l'utilisateur ou alors le passer en argument
		$request = $this->connection->prepare("SELECT uid from CONVERSATION_SUBSCRIBE where id_conversation = ?;");
		if ($request===false) return false;
		if (!$request->execute(array($id_conversation))) return false;
		
		$heDoesNotWantToChatAnymore = $request;
		if($heDoesNotWantToChatAnymore == )
	}
	
	
	/* s'il reste 0 personnes, supprimer la conversation */
	public isThereStillPeopleInConversation($id_conversation) {
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
	
	
	/* si closed = 1, supprimer la conversation
	   du coup, c'est soit on garde cette fonction, soit on met juste closed à 1 pour conserver une archive
	 */
	public function deleteConversation($id_conversation) {
		$request = $this->connection->prepare("DELETE * from CONVERSATION where id_conversation = ?;");
		if ($request===false) return false;
		if (!$request->execute(array($id_conversation))) return false;
		return true;
	}
	
	/* supprimer un événement en fonction de la volonté de owner_uid */
	public removeEventByUser($id_suppresser, $id_event) {
		$request = $this->connection->prepare("SELECT owner_uid from EVENT where id_event = ?;");
		if ($request===false) return false;
		if (!$request->execute(array($id_event))) return false;
		
		$owner_uid = $request;
		if($id_suppresser == $owner_uid) { /* attention, bien vérifier que les types sont identiques (retour du getter) pour mettre un === */
			$request = $this->connection->prepare("DELETE * from EVENT where owner_uid = ?;");
			if ($request===false) return false;
			if (!$request->execute(array($owner_uid))) return false;
			return true;
		}
		else return false; /* contre les injections, owner_uid et id_suppresser ne correspondent pas. */
	}
	
	
	/* supprimer un événement si ends est une date du passé 
	   empêcher à tout moment d'avoir accès à owner_uid (et si on a le temps à n'importe quel attribut de la BDD ofc)
	*/
	
	/*
	connection de l'utilisateur à son compte
	avec vérification du login et du mdp si le login et le mdp correcponde bien a un utilisateur
	*/
	public function connect_session($login, $mdp){
		$req = "SELECT uid FROM Utilisateur WHERE username = '$login' AND  passwd = '$mdp' " ;
		$rs = Database::$connection->query($req);
		$ligne = $rs->fetch(PDO::FETCH_ASSOC);
		return $ligne;
	}
	
	/*
	retirer un utilisateur d'une conversation
	*/
	public function remove_user_conversation($id_conversation, $uid){
		$req = "DELETE FROM conversation_subscribe WHERE id_conversation = '$id_conversation' AND uid = '$uid' " ;
		$rs = Database::$connection->prepare($req);
		$rs->execute();
		isThereStillPeopleInConversation($id_conversation);
	}
	
	/*
	suppression de l'evenement
	soit date de fin de l'event
	*/
	public function remove_event_by_date(){
		$today = date("Y-m-d H:i:s");   
		$req = "DELETE FROM event WHERE ends < '$today' " ;
		$rs = Database::$connection->prepare($req);
		$rs->execute();
	}
	
	/*
	bloquer l'event pour qu'il n'y ait plus d'utilisateur qui puissent
	participer à l'event 
	*/
	public function block_event($id_event){
		$today = date("Y-m-d H:i:s"); 
		$req = "SELECT id_event FROM event WHERE begins = '$today' AND id_event = '$id_event' ";
		$rs = Database::$connection->query($req);
		$ligne = $rs->fetch(PDO::FETCH_ASSOC);
		if($ligne != null){
			return true;
		}else{
			return false
		}
	}

?>