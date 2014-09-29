<?php
require_once("views/View.inc.php");

class GetMyEstablishmentView extends View {
	public $establishments;
	
	public function setEstablishments($estab){$this->establishments = $estab;}

	/**
	 * Affiche la vue de la recherche faite par l'utilisateur.
	 *
	 * @see View::displayBody()
	 */
	public function displayBody() {
		$establishments = $this->establishments;
		require("templates/getmyestablishment.inc.php");
	}

}
?>
