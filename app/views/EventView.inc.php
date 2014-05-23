<?php
require_once("views/View.inc.php");
require_once(dirname(__FILE__) . "/../classes/user.class.php");
require_once(dirname(__FILE__) . "/../classes/event.class.php");

class EventView extends View {

	private $event;

	/**
	 * Affiche la liste des événements créés par un utilisateur.
	 *
	 * @see View::displayBody()
	 */
	public function displayBody(){
		if(isset($_COOKIE['uid']) && isset($_COOKIE['sesstoken'])){
			$uid = $_COOKIE['uid'];
			$sesstoken = $_COOKIE['sesstoken'];
			$user = User::getUserByUIDAndSessToken($uid, $sesstoken);
		}

		if (is_null($event)) {
			echo '<div class="container"><br>br><br><br><div style="text-align:center" class="alert">Cet événement n\'existe pas.</div></div>';
			return;
		}
		
		require("templates/event.inc.php");
	}
	
	/**
	 * Fixe les événements à afficher.
	 *	 * @param array<Events> $events événements à afficher. 
	 *
	 */
	 public function setEvent($event) {
	 	 $this->event = $event;
	 }
	
}
?>