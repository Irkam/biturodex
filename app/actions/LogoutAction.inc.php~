<? 

require_once("actions/Action.inc.php");

class LogoutAction extends Action {

	/**
	 * Déconnecte l'utilisateur courant. Pour cela, la valeur 'null'
	 * est affectée à la variable de session 'login' à l'aide d'une méthode
	 * de la classe Action.
	 *
	 * @see Action::run()
	 */	
	public function run() {
		$this->setSessionLogin(null);
		$this->setView(getViewByName("Default"));
	}

}


