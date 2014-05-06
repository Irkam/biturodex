<?
require_once("views/View.inc.php");

class MessageView extends View {

	/**
	 * Affiche un message à l'utilisateur.
	 *
	 * @see View::displayBody()
	 */
	public function displayBody() { 
		echo '<div class="container"><br>br><br><br><div style="text-align:center" class="alert '.$this->style.'">'.$this->message.'</div></div>';
	}

}
?>
