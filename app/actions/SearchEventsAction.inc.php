<?php

require_once("model/Survey.inc.php");
require_once("model/Response.inc.php");
require_once("actions/Action.inc.php");
require_once(dirname(__FILE__)."/../classes/db.class.php");
require_once(dirname(__FILE__)."/../classes/event.class.php");

class SearchEventsAction extends Action {

	/**
	 * Traite les données envoyées par le formulaire de création d'événement.
	 *
	 * Si l'utilisateur n'est pas connecté, un message lui demandant de se connecter est affiché.
	 *
	 * Sinon, la fonction ajoute l'événement à la base de données.
	 *
	 * Après validation, l'un des messages suivants est affiché à l'utilisateur :
	 * - "Le remplissage des champs marqués d'un * est obligatoire.";
	 * - "Votre événement a bien été créé.".
	 * 
	 * @see Action::run()
	 */
	public function run() {
		$searchstring = $_GET['s'];
		$keywords = split(" ", $searchstring);
		
		$events = Event::getEventsByName($keywords);
		$res = $events->getEventsByName($keywords);
		$_SESSION = $res;
		
		if (!is_null($res)) {
			$this->setCreateEstablishmentFormView($res);
			$this->setMessageView("Votre établissement a bien été créé");
		} else $this->setSearchFormView($res);	
		?>
		<table>
			
		<?php
		foreach($events as $event){
			echo("<tr><td>" . $event->name . "</td><td>" . $event->starts . "</td></tr>");
		}
		?>
		
		</table>
		<?php
	}
	
	private function setSearchFormView($message) {
		$this->setView(getViewByName("SearchForm"));
		$this->getView()->setMessage($message, "alert-error");
	}
}

?>
