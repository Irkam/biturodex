<?php
require_once("actions/Action.inc.php");

class CreateConversationFormAction extends Action {

	/**
	 * 
	 *
	 * @see Action::run()
	 */
	public function run() {
		
		if ($this->getSessionLogin()===null) {
			$this->setMessageView("Vous devez être authentifié.", "alert-error");
			return;
		}
		
		$this->setView(getViewByName("CreateConversationForm"));
	}

}

?>