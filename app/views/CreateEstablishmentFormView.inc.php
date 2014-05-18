<?php
require_once("views/View.inc.php");

class CreateEstablishmentFormView extends View {

	/**
	 * Affiche le formulaire de création d'établissement.
	 *
	 * @see View::displayBody()
	 */
	public function displayBody() {
		require("templates/createestablishmentform.inc.php");
	}

}
?>


