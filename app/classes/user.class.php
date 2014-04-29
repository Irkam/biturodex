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
	protected $encryptedpasswd;
	
	private $unencryptedpasswd;
	
	/**
	 * Chiffre un mot de passe.
	 * 
	 * @param str string mot de passe non-chiffré
	 * 
	 * @return str mot de passe chiffré et paré à décoller
	 */
	public static function cryptPasswd($str){
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
		$request = $db->prepare("SELECT user.uid, user.username, user.mailaddress, user.name, user.firstname WHERE uid = ?");
		
		if ($request===false) return json_encode(array("error", "PDO error"));
		if (!$request->execute(array($uid))) return json_encode(array("error", "PDO error"));
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
	}
	
	
	public static function createUser($username, $mailaddress, $passwd, $name, $firstname){
		$user = new User();
		$user->username = $username;
		$user->email = $mailaddress;
		$user->unencryptedpasswd = $passwd;		//DEPRECATED
		$user->name = $name;
		$user->firstname = $firstname;
		
		$user->encryptedpasswd = User::cryptPasswd($passwd);
		
		return $user;
	}

	
	/**
	 * Vérifie qu'un couple (pseudonyme, mot de passe) est correct et connecte l'utilisateur
	 * Le token de session de l'utilisateur est mis à jour.
	 *
	 * @param string $username Pseudonyme.
	 * @param string $password Mot de passe chiffré à l'aide de la fonction User::cryptPasswd
	 * @return boolean true si le couple est correct, false sinon.
	 */
	public static function connectUser($username, $passwd){
		$db = new db();
		$request = $db->prepare("select * from users username where username = ? and password = ?");
		if ($request===false) return false;
		if(!$request->execute(array($username, $password))) return false;
		
		if($request->rowCount()===0)
			return json_encode(array("error", "unvalid username and/or password"));
		
		$res = $request->fetch(PDO::FETCH_ASSOC);
		
		$user = new User();
		$user->username = $res['username'];
		$user->email = $res['mailaddress'];
		$user->encryptedpasswd = $res['passwd'];
		$user->name = $res['name'];
		$user->firstname = $res['firstname'];
		
		$user->sessionToken = $user->generateSessToken();
		
		$stmt = $db->prepare("UPDATE user SET sesstoken = :newtoken WHERE username = :username AND passwd = :passwd");
		$stmt->bindParam('newtoken', $user->sessionToken);
		$stmt->bindParam('username', $user->username);
		$stmt->bindParam('passwd', $user->encryptedpasswd);
		
		try{
			$stmt->execute();
		}catch(PDOException $e){
			echo json_encode(array("error", $e->getMessage()));
			return null;
		}
		
		return $user;
	}
	
	/**
	 * Default constructor
	 */
	function __construct(){
		
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
	 * Returns a new session token for the user
	 * 
	 * ABSOLUTELY NOT SECURE
	 * TODO: secure with mcrypt symetric cipher.
	 * 
	 * @return string a freshly made session token
	 */
	private function generateSessToken(){
		if(is_null($this->username) || is_null($this->encryptedpasswd))
			return null;
		
		return base64_encode(md5("bitur" . $this->username . $this->encryptedpasswd . "odex") . strval(DateTime::getTimestamp()));
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
	 * Ajoute un nouveau compte utilisateur si le pseudonyme est valide et disponible et
	 * si le mot de passe est valide. La méthode peut retourner un des messages d'erreur qui suivent :
	 * - "Le pseudo doit contenir entre 3 et 30 lettres.";
	 * - "Le mot de passe doit contenir entre 3 et 256 caractères.";
	 * - "Le pseudo existe déjà.".
	 *
	 * @return boolean|string true si le couple a été ajouté avec succès, un message d'erreur sinon.
	 */
	public function addUser(){
	  	if(!$this->checkUsernameValidity($username))
	  		return json_encode(array("error", "Le pseudo doit contenir entre 3 et 60 lettres."));
	  		
	  	if(!$this->checkPasswordValidity($password))
	  		return json_encode(array("error", "Le mot de passe doit contenir entre 3 et 256 caractères"));
	  		
	  	if(!$this->checkUsernameAvailability($username))
	  		return json_encode(array("error", "Le pseudo existe déjà"));
	  	
		$db = new db();
	  	$request = $db->prepare('INSERT INTO user(name, firstname, username, mailaddress, password) VALUES (?,?,?,?,?,?,?,?,?)');
	  	
		$res = $request->execute(array($this->name, $this->firstname, $this->username, $this->email, $this->passwd));
	  	if(!$res) return json_encode(array("error", "Couldn't add user"));
	  	
	  	return json_encode(array("error", 0));
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
	public function updatePassword($username, $oldpassword, $password) {
		if(!$this->checkPasswordValidity($password))
	  		return "Le mot de passe doit contenir entre 3 et 256 caractères";

	  	$db = new db();
		$request = $db->prepare('update user set password = ? where username = ? and passwd = ?;');
		
		$query = $request->execute(array($password,$username, $this->cryptPasswd($oldpassword)));
		if (!$query) {
   			 echo "\n*** PDO: Erreur MySQL *** \n";
             print_r($db->errorInfo());
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
		$db = new db();
		$request = $db->prepare("DELETE FROM conversation_subscribe WHERE id_conversation = ? AND uid = ?;");
		if ($request===false) return false;
		if (!$request->execute(array($id_conversation, $this->uid))) return false;
		return true;
	}
	
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
