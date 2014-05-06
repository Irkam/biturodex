<?

require_once("actions/Action.inc.php");

class SignUpAction extends Action {

	/**
	 * Traite les données envoyées par le formulaire d'inscription
	 * ($_POST['signUpLogin'], $_POST['signUpPassword'], $_POST['signUpPassword2']).
	 *
	 * Le compte est crée à l'aide de la méthode 'addUser' de la classe Database.
	 *
	 * Si la fonction 'addUser' retourne une erreur ou si le mot de passe et sa confirmation
	 * sont différents, on envoie l'utilisateur vers la vue 'SignUpForm' contenant 
	 * le message retourné par 'addUser' ou la chaîne "Le mot de passe et sa confirmation 
	 * sont différents.";
	 *
	 * Si l'inscription est validée, le visiteur est envoyé vers la vue 'MessageView' avec
	 * un message confirmant son inscription.
	 *
	 * @see Action::run()
	 */
	public function run() {
		$username = $_POST['username'];
		$password = $_POST['passwd']; 
		$passwordConfirmation = $_POST['confirmation'];
		$name = $_POST['name'];
		$firstname = $_POST['firstname'];
		$mailaddress = $_POST['mailaddress'];
		
		if(! isset($username)) { $this->setSignUpFormView("erreur : pseudo non défini"); return ;}
		if(! isset($password)) { $this->setSignUpFormView("erreur : mot de passe non défini"); return; }
		if(! isset($passwordConfirmation)) { $this->setSignUpFormView("erreur : veuillez confirmer votre mot de passe"); return; }
		if(! isset($mailaddress)) { $this->setSignUpFormView("erreur : e-mail non défini"); return ;}
		
		if($password != $passwordConfirmation) {
			$this->setSignUpFormView("erreur : le mot de passe et sa confirmation sont différents"); 
			return;
		}
		
		$res = $this->database->addUser($username, $password, $name, $firstname, $mailaddress);
		
		if ($res===true) {
			$this->setSignUpFormView($res);
			$this->setMessageView("inscription validée");
		} else $this->setSignUpFormView($res);
	}

	private function setSignUpFormView($message) {
		$this->setView(getViewByName("SignUpForm"));
		$this->getView()->setMessage($message);
	}
}
?>
