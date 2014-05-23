<?php
require_once("views/View.inc.php");
require_once(dirname(__FILE__) . "/../classes/user.class.php");
require_once(dirname(__FILE__) . "/../classes/event.class.php");

class EventView extends View {

	public $event;

	/**
	 * Affiche la liste des événements créés par un utilisateur.
	 *
	 * @see View::displayBody()
	 */
	public function displayBody(){
		
		
		if($_SESSION['login'] != null){
			$user = User::getUserByUsername($_SESSION['login']);
		}else{
			$user = null;
		}
		if (is_null($this->event)) {
			echo '<div class="container"><br>br><br><br><div style="text-align:center" class="alert">Cet événement n\'existe pas.</div></div>';
			return;
		}
		
		$event = $this->event;
		require("templates/event.inc.php");

		
	}
	
	 public function setEvent($event) {
	 	 $this->event = $event;
	 }
	
}
?>