<?
require_once("views/View.inc.php");

class CreateConversationFormView extends View {

	/**
	 * Affiche le formulaire de création d'établissement.
	 *
	 * @see View::displayBody()
	 */
	public function displayBody() {
		require("templates/createconversationform.inc.php");
	}

}
?>
