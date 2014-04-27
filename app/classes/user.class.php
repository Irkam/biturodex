<?php

class User{
	public $uid;
	public $username;
	public $email;
	public $name;
	public $firstname;
	protected $sessionToken;
	
	/**
	Renvoie un utilisateur en fonction de son UID. Ne peut être utilisé pour connecter un utilisateur
	(ne renvoie pas de token de session)
	*/
	function __construct($uid){
	}
	
	/**
	Renvoie un utilisateur connecté à l'aide des deux paramètres, et initialise son token de session.
	*/
	function __construct($username, $passwd){
	}

	/**
	Renvoie un utilisateur connecté à l'aide des deux paramètres, et initialise son token de session.
	*/
	function __construct($email, $passwd){
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
	public function checkUsernameAvailability($username) {
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
	
	/**
	Récupère les statistiques concernant l'utilisateur
	*/
	public function getUserStats(){
	
	}
	
	/**
	Récupère les statistiques émises par l'utilisateur
	*/	
	public function getStatsByUser(){

	}
	
	/**
	 * chaque utilisateur peut se retirer d'une conversation */
	public function unsubscribeToConversation($id_conversation) {
		// un get pour récupérer l'id de l'utilisateur ou alors le passer en argument
		$request = $this->connection->prepare("SELECT uid from CONVERSATION_SUBSCRIBE where id_conversation = ?;");
		if ($request===false) return false;
		if (!$request->execute(array($id_conversation))) return false;
		
		$heDoesNotWantToChatAnymore = $request;
		//if($heDoesNotWantToChatAnymore)
	}
}

?>
