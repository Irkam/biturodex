<?php
require_once("views/View.inc.php");

class IncorrectPasswordView extends View {

	public function displayBody() {
		echo("Mot de passe incorrect");
	}
}
?>