<?
require_once("actions/Action.inc.php");

class UpdateUserFormAction extends Action {

	/**
	 * Dirige l'utilisateur vers le formulaire de modification de mot de passe.
	 *
	 * @see Action::run()
	 */
	public function run() {

		if ($this->getSessionLogin()===null) {
			$this->setMessageView("Vous devez être authentifié.");
			return;
		}

		$this->setView(getViewByName("UpdateUserForm"));
	}

}
?>
