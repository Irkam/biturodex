<?php

// CreateEventAction.inc.php

require_once(dirname(__FILE__) . "/Action.inc.php");
require_once(dirname(__FILE__) . "/../classes/event.class.php");

class CreateEventAction extends Action {

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
		$owner = $this->getSessionLogin();
		if($owner == null) { setMessageView("Vous n'êtes pas connecté"); return; }

		//à gérer avec le datepicker
		/*$beginsDay = ;
		$beginsMonth = ;
		$beginsYear = ;
		$endsDay = ;
		$endsMonth = ;
		$endsYear = ;*/
		
		
		$typeEvent = "bidon";
		$place = &$_POST['place'];
		$eventName = &$_POST['establishmentName']; // peut être vide si l'événement n'a pas lieu dans un établissement répertorié dans la BDD
		$address0 = &$_POST['address0'];
		$address2 = &$_POST['address2'];
		$postcode = &$_POST['postcode'];
		$city = &$_POST['city'];
		$lng = 1;
		$lat = 1;
		$rad = 1;
		$starts = "1" ;
		$end = "1";
		$uid = 1;

		// insérer les dates données via le datepicker
		if (empty($place) || empty($address0) || empty($postcode) || empty($city)) {
			$this->setCreateEventFormView("Le remplissage des champs marqués d'un * est obligatoire.");
			return;
		}
		
		//$name, $type, $own_uid, $lat, $lng, $rad, $address=null, $estab=null, $starts, $ends
		
		$event = Event::createEvent($eventName, $typeEvent, $uid, $lat, $lng, $rad, $address=null, $estab=null, $starts, $ends);
		$result = $event->addEvent();

		if (!$result) {
			$this->setCreateEventFormView("Impossible de créer votre événement.");
			return;
		}
		$this->setMessageView("Votre événement a été créé avec succès.");

	}

	private function setCreateEventFormView($message) {
		$this->setView(getViewByName("CreateEventForm"));
		$this->getView()->setMessage($message, "alert-error");
	}
}

?>