<?

require_once("actions/Action.inc.php");

class SignUpFormAction extends Action {

	/**
	 * Dirige l'utilisateur vers le formulaire d'inscription.
	 *
	 * @see Action::run()
	 */	
	public function run() {
		$this->setView(getViewByName("SignUpForm"));
	}

}

?>
