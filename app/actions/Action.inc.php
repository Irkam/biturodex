<?

require_once("model/Database.inc.php");

abstract class Action {
	private $view;
	protected $database;

	/**
	 * Construit une instance de la classe Action.
	 */
	public function __construct(){
		$this->view = null;
		$this->database = new Database();
	}

	/**
	 * Fixe la vue qui doit être affichée par le contrôleur.
	 *
	 * @param View $view Vue qui doit être affichée par le contrôleur.
	 */
	protected function setView($view) {
		$this->view = $view;
	}

	/**
	 * Retourne la vue qui doit être affichée par le contrôleur.
	 * 
	 * @return View Vue qui doit être affichée par le contrôleur.
	 */
	public function getView() {
		return $this->view;
	}

	/**
	 * Récupère le pseudonyme de l'utilisateur s'il est connecté, ou null sinon.
	 *
	 * @return string Pseudonyme de l'utilisateur ou null.
	 */
	public function getSessionLogin() {
		if (isset($_SESSION['login'])) {
			$login = $_SESSION['login'];
		} else $login = null;
		return $login;
	}

	/**
	 * Sauvegarde le pseudonyme de l'utilisateur dans la session.
	 *
	 * @param string $login Pseudonyme de l'utilisateur.
	 */
	protected function setSessionLogin($login) {
		$_SESSION['login'] = $login;
	}

	/**
	 * Fixe la vue de façon à afficher un message à l'utilisateur.
	 * 
	 * @param string $message Message à afficher à l'utilisateur.
	 * @param string $style style de l'affichage.
	 */
	protected function setMessageView($message, $style="") {
		$this->setView(getViewByName("Message"));
		$this->getView()->setMessage($message, $style);
	}

	/**
	 * Méthode qui doit être implémentée par chaque action afin de décrire
	 * son comportement.
	 */
	abstract public function run();
}
?>
