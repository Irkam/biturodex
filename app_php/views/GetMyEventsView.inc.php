<?php
require_once("views/View.inc.php");

class GetMyEventsView extends View {
	public $events;
	
	public function setEvents($events){$this->events = $events;}

	/**
	 * Affiche la vue de la recherche faite par l'utilisateur.
	 *
	 * @see View::displayBody()
	 */
	public function displayBody() {
		$events = $this->events;
		require("templates/getmyevents.inc.php");
	}

}
?>
