<?php
require_once("views/View.inc.php");

class SignUpFormView extends View {
	
	/**
	 * Affiche le formulaire d'inscription.
	 *
	 * @see View::displayBody()
	 */
	public function displayBody() {
		require("templates/signupform.inc.php");
	}

}
?>


