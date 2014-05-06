<?

require_once("actions/Action.inc.php");

class GetMySurveysAction extends Action {

	/**
	 * Construit la liste des sondages de l'utilisateur et le dirige vers la vue "SurveysView" 
	 * de façon à afficher les sondages.
	 *
	 * Si l'utilisateur n'est pas connecté, un message lui demandant de se connecter est affiché.
	 *
	 * @see Action::run()
	 */
	public function run() {
		$owner = $this->getSessionLogin();
		if($owner == null) { setMessageView("Vous n'êtes pas connecté"); return; }
		
		$surveys = $this->database->loadSurveysByOwner($owner);
		
		$this->setView(getViewByName("Surveys"));	
		
		
		$this->getView()->setSurveys($surveys);
	}

}

?>
