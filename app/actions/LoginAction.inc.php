<?

require_once("actions/Action.inc.php");
require_once(dirname(__FILE__)."/../classes/db.class.php");
require_once(dirname(__FILE__)."/../classes/user.class.php");

class LoginAction extends Action {

	/**
	 * Traite les données envoyées par le visiteur via le formulaire de connexion
	 * (variables $_POST['nickname'] et $_POST['password']).
	 * Le mot de passe est vérifié en utilisant les méthodes de la classe Database.
	 * Si le mot de passe n'est pas correct, on affiche le message "Pseudo ou mot de passe incorrect."
	 * Si la vérification est réussie, le pseudo est affecté à la variable de session.
	 *
	 * @see Action::run()
	 */
	public function run() {
  		$login = $_POST['nickname'];
  		$password = $_POST['password'];
  		
  		if(! isset($login)) $this->setMessageView("erreur : entrez votre pseudo");
		if(! isset($password)) $this->setMessageView("erreur : entrez votre mot de passe");
  		
		$user = User::connectUser($login, $password);
  		
  		if(is_null($user)) { $this->setView(getViewByName("Pseudo ou mot de passe incorrect")); return; }
		else {
			$this->setMessageView("Connecté en tant que ".$login);
			$this->setSessionLogin($login);
		}
	}

}

?>
