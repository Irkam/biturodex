<?php
require_once("actions/Action.inc.php");
require_once(dirname(__FILE__) . "/../classes/Establishment.class.php");

class CreateEstablishmentFormAction extends Action {

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
		
		$this->setView(getViewByName("CreateEstablishmentForm"));
	}

}

?>