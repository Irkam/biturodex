<?php

require_once("actions/Action.inc.php");
require_once(dirname(__FILE__)."/../classes/event.class.php");

class GetMyEventsAction extends Action {

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
		/*$searchstring = $_POST['keyword'];
		$keywords = preg_split("/\s+/", $searchstring);*/
		$uname = $_SESSION['login'];
		
		$events = Event::getEventsSubscribedAndOwnedByUsername($uname);
		//$res = $events->getEventsByName($keywords);
		
		
		//if (!is_null($res)) {
		//	$this->setCreateEstablishmentFormView($res);
		//	$this->setMessageView("Votre établissement a bien été créé");
		//} else $this->setSearchFormView($res);	
		?>
		<table>
			
		<?php
		
		
		?>
		
		</table>
		<?php
		
		if (is_null($events)) {
			$this->setSearchFormView("toast", $events);
			$this->setMessageAndEstablishments("Vous n'avez pas d'établissement");
		}else{
			$this->setMessageAndEstablishments("", $events);
			//$this->setMessageView("Toast");
		}
	}
	
	private function setMessageAndEstablishments($message, $events) {
		$this->setView(getViewByName("GetMyEvents"));
		$this->getView()->setMessage($message, "alert-error");
		$this->getView()->setEvents($events);
	}
}

?>
