<?php
require_once("views/View.inc.php");

class EventsView extends View {

	private $events;

	/**
	 * Affiche la liste des événements créés par un utilisateur.
	 *
	 * @see View::displayBody()
	 */
	public function displayBody() {

		if (count($this->events)===0) {
			echo '<div class="container"><br>br><br><br><div style="text-align:center" class="alert">Vous n'avez créé aucun événement.</div></div>';
			return;
		}
		
		require("templates/events.inc.php");
	}
	
	/**
	 * Fixe les événements à afficher.
	 *	 * @param array<Events> $events événements à afficher. 
	 *
	 */
	 public function setEvents($events) {
	 	 $this->events = $events;
	 }
	
}
?>