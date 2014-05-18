<?php
require_once(dirname(__FILE__) . "/../config.inc.php");
require_once(dirname(__FILE__) . "/db.class.php");

class User{
	public $uid;
	public $username;
	public $email;
	public $name;
	public $firstname;
	protected $sessionToken;
	protected $sessionTimestamp;
	protected $encryptedpasswd;
	
	const MAX_SESSION_TIME = 3600;
	
	/**
	 * Chiffre un mot de passe.
	 * 
	 * @param str string mot de passe non-chiffré
	 * 
	 * @return str mot de passe chiffré et paré à décoller
	 */
	public static function encryptPassword($str){
		return crypt($str, "$2a$" . _DB_PASSWD_SALT_NUM_ . "$" . _DB_PASSWD_SALT_STR_ . "$");
	}
	
	/**
	 * Renvoie un utilisateur en fonction de son UID. Ne peut être utilisé pour connecter un utilisateur
	 * (ne renvoie pas de token de session)
	 * 
	 * @param uid int numéro d'utilisateur
	 */
	public static function getUserByUID($uid){
		$db = new db();
		$request = $db->prepare("SELECT user.uid, user.username, user.mailaddress, user.name, user.firstname 
		FROM user WHERE uid = ?");
		
		if ($request===false) return json_encode(array("error", "PDO error"));
		
		try{
			$request->execute(array(intval($uid)));
			
			if($request->rowCount()==0)
				return json_encode(array("error", "no such user"));
			
			$result = $request->fetch(PDO::FETCH_OBJ);
			
			$user = new User();
			$user->uid = $uid;
			$user->username = $result->username;
			$user->email = $result->mailaddress;
			$user->name = $result->name;
			$user->firstname = $result->firstname;
			
			return $user;
		
		}catch(PDOException $e){
			return json_encode(array("error", "PDO error"));
		}
	}
	
	/**
	 * Renvoie un utilisateur en fonction de son UID. Ne peut être utilisé pour connecter un utilisateur
	 * (ne renvoie pas de token de session)
	 * 
	 * @param uid int numéro d'utilisateur
	 */
	public static function getUserByUIDAndSessToken($uid, $token){
		$db = new db();
		$request = $db->prepare("SELECT user.uid, user.username, user.mailaddress, user.name, user.firstname 
		FROM user WHERE uid = :uid AND sesstoken = :token");
		$request->bindParam(":uid", $uid);
		$request->bindParam(":token", $token);
		
		if ($request===false) return json_encode(array("error", "PDO error"));
		
		try{
			$request->execute();
			
			if($request->rowCount()==0)
				return NULL;
			
			$result = $request->fetch(PDO::FETCH_OBJ);
			
			$user = new User();
			$user->uid = $uid;
			$user->username = $result->username;
			$user->email = $result->mailaddress;
			$user->name = $result->name;
			$user->firstname = $result->firstname;
			
			return $user;
		
		}catch(PDOException $e){
			throw $e;
			return NULL;
		}
	}
	
	
	public static function createUser($username, $mailaddress, $passwd, $name, $firstname){
		$user = new User();
		$user->username = $username;
		$user->email = $mailaddress;
		$user->name = $name;
		$user->firstname = $firstname;
		
		$user->encryptedpasswd = User::encryptPassword($passwd);
		
		if(!$user->checkUsernameValidity()){
	  		echo json_encode(array("error", "Le pseudo doit contenir entre 3 et 60 lettres."));
			return null;
		}
		
		if(!$user->checkUsernameAvailability()){
	  		echo json_encode(array("error", "Le pseudo existe déjà"));
			return null;
		}
	  	
	  	if(!$user->checkPasswordValidity($passwd)){
	  		echo json_encode(array("error", "Le mot de passe doit contenir entre 3 et 256 caractères"));
			return null;
		}
		
		return $user;
	}

	
	/**
	 * Vérifie qu'un couple (pseudonyme, mot de passe) est correct et connecte l'utilisateur
	 * Le token de session de l'utilisateur est mis à jour.
	 * 
	 * TODO: Secure cookies
	 *
	 * @param string $username Pseudonyme.
	 * @param string $password Mot de passe chiffré à l'aide de la fonction User::encryptPassword
	 * @return boolean true si le couple est correct, false sinon.
	 */
	public static function connectUser($username, $passwd, $setcookies=TRUE){
		$db = new db();
		$request = $db->prepare("select * from user where username = ? and passwd = ?");
		if ($request===false) return false;
		
		try{
			$request->execute(array($username, $passwd));
						
			if($request->rowCount()!=1){
				echo $request->rowCount();
				echo json_encode(array("error", "unvalid username and/or password"));
				return null;
			}
			
			$res = $request->fetch(PDO::FETCH_ASSOC);
			
			$user = new User();
			$user->uid = intval($res['uid']);
			$user->username = $res['username'];
			$user->email = $res['mailaddress'];
			$user->encryptedpasswd = $res['passwd'];
			$user->name = $res['name'];
			$user->firstname = $res['firstname'];
			
			$user->sessionTimestamp = time();
			$user->sessionToken = $user->generateSessToken($user->sessionTimestamp);
			
			$stmt = $db->prepare("UPDATE user SET sesstoken = :newtoken, sesstimestamp = FROM_UNIXTIME(:timestamp) WHERE username = :username AND passwd = :passwd");
			$stmt->bindParam(':newtoken', $user->sessionToken);
			$stmt->bindParam(':username', $user->username);
			$stmt->bindParam(':passwd', $user->encryptedpasswd);
			$stmt->bindParam(':timestamp', $user->sessionTimestamp);
			
			try{
				$stmt->execute();
			}catch(PDOException $e){
				echo json_encode(array("error", $e->getMessage()));
				return null;
			}
			
			setcookie('uid', $user->getUID());
			setcookie('sesstoken', $user->getSessToken());
			
			return $user;
		}catch(PDOException $e){
			echo json_encode(array("error", $e->getMessage()));
		}
		
		return null;
	}
	
	/**
	 * Default constructor
	 */
	function __construct(){
		
	}
	
	/**
	 * Returns a new session token for the user
	 * 
	 * ABSOLUTELY NOT SECURE
	 * TODO: secure with mcrypt symetric cipher.
	 * 
	 * @return string a freshly made session token
	 */
	private function generateSessToken($sesstimestamp){
		if(is_null($this->username) || is_null($this->encryptedpasswd))
			return null;
		
		return base64_encode(md5("bitur" . $this->username . $this->encryptedpasswd . "odex") . strval($sesstimestamp));
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
	 * Vérifie si un pseudonyme est valide, c'est-à-dire,
	 * s'il contient entre 3 et 60 caractères et uniquement des lettres.
	 *
	 * @param string $username Pseudonyme à vérifier.
	 * @return boolean true si le pseudonyme est valide, false sinon.
	 */
	private function checkUsernameValidity() {
		$usernameLength = strlen($this->username); 
		if($usernameLength < 3 || $usernameLength > 60)
			return false;
		return ctype_alpha($this->username);
	}

	/**
	 * Vérifie la disponibilité d'un pseudonyme.
	 *
	 * @param string $username Pseudonyme à vérifier.
	 * @return boolean true si le pseudonyme est disponible, false sinon.
	 */
	public function checkUsernameAvailability() {
		$db = new db();
		$request = $db->prepare("select username from user where username = ?;");
		if ($request===false) return false;
		if (!$request->execute(array($this->username))) return false;
		return $request->rowCount()===0;
	}

	/**
	 * Ajoute un nouveau compte utilisateur si le pseudonyme est valide et disponible et
	 * si le mot de passe est valide. La méthode peut retourner un des messages d'erreur qui suivent :
	 * - "Le pseudo doit contenir entre 3 et 30 lettres.";
	 * - "Le mot de passe doit contenir entre 3 et 256 caractères.";
	 * - "Le pseudo existe déjà.".
	 *
	 * @return boolean|string true si le couple a été ajouté avec succès, un message d'erreur sinon.
	 */
	public function addUser(){	  	
		$db = new db();
	  	$request = $db->prepare('INSERT INTO user(name, firstname, username, mailaddress, passwd) VALUES (?,?,?,?,?)');
	  	
		try{
			$request->execute(array($this->name, $this->firstname, $this->username, $this->email, $this->encryptedpasswd));
			$this->uid = $db->lastInsertId();
			return $this;
		}catch(PDOException $e){
	  		//return json_encode(array("error", "Couldn't add user : " . $e->getError()));
	  		return null;
	  	}
	  	
	  	//return json_encode(array("error", $db->errorInfo()));
	  	return null;
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
	 */
	public function updatePassword($newpassword) {
		if(!$this->checkPasswordValidity($newpassword))
	  		return false;
		$newpasswd = User::encryptPassword($newpassword);

	  	$db = new db();
		$request = $db->prepare('UPDATE `user` SET `passwd`=:newpasswd WHERE `uid`=:uid AND `passwd`=:oldpasswd');
		$request->bindParam(":uid", $this->uid, PDO::PARAM_INT);
		$request->bindParam(":newpasswd", $newpasswd);
		$request->bindParam(":oldpasswd", $this->encryptedpasswd);
		
		try{
			if(!$request->execute())
				return false;
		}catch(PDOException $e){
			echo json_encode(array("error", $e->getError()));
			return false;
		}
		
		$this->encryptedpasswd = $newpasswd;
		
	 	return true;
	}
	
	/**
	 * TODO
	 */
	public function updatePicture($picture){
		if(is_null($picture)) return false;
		if($picutre['error'] != UPLOAD_ERR_OK){
			
			return false;
		}
		
		$uploaddest = _UPLOAD_DIR_ . basename($picture['name']);
		if(move_uploaded_file($picutre['tmp_name'], $uploaddest)) return true;
		else return false;
	}
	
	/**
	Récupère les statistiques concernant l'utilisateur
	*/
	public function getStatsForThisUser(){
	}
	
	/**
	Récupère les statistiques émises par l'utilisateur
	*/	
	public function getStatsByThisUser(){
	}
	
	/**
	 * chaque utilisateur peut se retirer d'une conversation */
	public function unsubscribeToConversation($id_conversation) {
		// un get pour récupérer l'id de l'utilisateur ou alors le passer en argument
		$db = new db();
		$request = $db->prepare("DELETE FROM conversation_subscribe WHERE id_conversation = ? AND uid = ?;");
		if ($request===false) return false;
		
		try{
			$request->execute(array($id_conversation, $this->uid));
		}catch(PDOException $e){
			echo json_encode(array("error", $e->getError()));
			return false;
		}
		return true;
	}
	
	public function getUID(){return $this->uid;}
	public function getSessToken(){return $this->sessionToken;}
	
	public function toJSON(){		
		return json_encode(array(
			array("uid", $this->uid),
			array("username", $this->username),
			array("email", $this->email),
			array("name", $this->name),
			array("firstname", $this->firstname),
		));
	}
}

?>
