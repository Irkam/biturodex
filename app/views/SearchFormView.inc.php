<?php
require_once("views/View.inc.php");

class SearchFormView extends View {

	/**
	 * Affiche la vue de la recherche faite par l'utilisateur.
	 *
	 * @see View::displayBody()
	 */
	public function displayBody() {
		require("templates/searchresultform.inc.php");
	}

}
?>
