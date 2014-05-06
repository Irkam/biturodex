<?

abstract class View {

	protected $message = "";
	protected $style = "";
	protected $login = null;

	/**
	 * Génère la page à afficher au client.
	 */
	public function run() {
		require("templates/page.inc.php");
	}

	/**
	 * Fixe le message qui doit être affichée par la vue.
	 *
	 * @param string $message Message à afficher.
	 * @param string $style Style du message à afficher.
	 */
	public function setMessage($message, $style="") {
		$this->message = $message;
		$this->style = $style;	
	}
	
	/**
	 * Fixe le login de l'utilisateur (s'il est connecté).
	 *
	 * @param string $login Login de l'utilisateur.
	 */
	public function setLogin($login) {
		$this->login = $login;	
	}	

	/**
	 * Génère le formulaire de connexion.
	 */
	private function displayLoginForm() {
		require("templates/loginform.inc.php");
	}

	/**
	 * Génère le formulaire de déconnexion.
	 */
	private function displayLogoutForm() {
		require("templates/logoutform.inc.php");
	}

	/**
	 * Génère une liste de commandes proposées à un utilisateur authentifié.
	 */
	private function displayCommands() {
		require("templates/commands.inc.php");
	}

	/**
	 * Génère le formulaire de recherche.
	 */
	private function displaySearchForm() {
		require("templates/searchform.inc.php");
	}

	/**
	 * Affiche le corps de la page. Cette méthode doit être
	 * implémentée par les différentes vues.
	 */
	protected abstract function displayBody();

}
