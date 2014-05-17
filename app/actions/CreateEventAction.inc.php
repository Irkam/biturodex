<?php

require_once("model/Survey.inc.php");
require_once("model/Response.inc.php");
require_once("actions/Action.inc.php");

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
	
		$formQuestion = &$_POST['questionSurvey'];
		
		if (empty($formQuestion)) {
			$this->setAddSurveyFormView("Vous devez saisir un titre.");
			return;
		}
		
		$survey = new Survey($owner, htmlentities($formQuestion));
		
		for ($i=1; $i<=5; $i++) {
			$formResponse = &$_POST['responseSurvey'.$i];
		  	if (!empty($formResponse)) {
		  		$survey->addResponse(new Response($survey, htmlentities($formResponse)));
			}
		}
		
		$result = $this->database->saveSurvey($survey);
		
		if (!$result) {
			$this->setAddSurveyFormView("Impossible de créer votre événement.");
			return;
		}

		$this->setMessageView("Votre événement a été créé avec succès.");
		
	}

	private function setAddSurveyFormView($message) {
		$this->setView(getViewByName("CreateEventForm"));
		$this->getView()->setMessage($message, "alert-error");
	}

}

?>
