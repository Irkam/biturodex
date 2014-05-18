<?php

require_once("actions/Action.inc.php");
require_once(dirname(__FILE__)."/../classes/db.class.php");
require_once(dirname(__FILE__)."/../classes/user.class.php");
require_once(dirname(__FILE__)."/../classes/inputs.class.php");

class UpdateUserAction extends Action {

	/**
	 * Met à jour le mot de passe de l'utilisateur en procédant de la façon suivante :
	 *
	 * Si toutes les données du formulaire de modification de profil ont été postées
	 * ($_POST['updatePassword'] et $_POST['updatePassword2']), on vérifie que
	 * le mot de passe et la confirmation sont identiques.
	 * S'ils le sont, on modifie le compte avec les méthodes de la classe 'Database'.
	 *
	 * Si une erreur se produit, le formulaire de modification de mot de passe
	 * est affiché à nouveau avec un message d'erreur.
	 *
	 * Si aucune erreur n'est détectée, le message 'Modification enregistrée.'
	 * est affiché à l'utilisateur.
	 * 
	 * TODO : remplacer getUserByUIDAndSessToken par getUserByCookies
	 *
	 * @see Action::run()
	 */
	public function run() {
		$user = User::getUserByUIDAndSessToken($_COOKIE['uid'], $_COOKIE['sesstoken']);
		$newPassword = $_POST['updatePassword'];
		$newPasswordConfirmation = $_POST['updatePassword2'];
		$nickname = $_SESSION['login'];
		$picture = $_FILES['updatePicture'];
		
		
		if($picture['error'] != UPLOAD_ERR_NO_FILE)
			if($picture['error'] == UPLOAD_ERR_OK){
				if($user->updatePicture($picture))
					$this->setMessageView("Image envoyée avec succès");
				else				
					$this->setMessageView("L'image n'a pu être envoyée");
			}else{
				$this->setMessageView("Erreur : image invalide");
			}
		
		$passwordLength = strlen($newPassword); 
		if($passwordLength < 3 && $passwordLength > 10)
			return "Le mot de passe doit contenir entre 3 et 10 caractères";
		
		if($newPassword != $newPasswordConfirmation) $this->setMessageView("erreur : le mot de passe et sa confirmation sont différents"); //return;
		
		//$res = $this->database->updateUser($nickname, $newPassword);
		$res = $user->updatePassword($newPassword);
		
		if(!$res) {
			$this->setMessageView("Erreur : mot de passe inchangé");
			return;
		}
		
		if ($res===true) {
			// $this->setSignUpFormView($res);
			 $this->setUpdateUserFormView("truc");
			$this->setMessageView("Modification enregistrée");
		} else $this->setSignUpFormView($res);
	}

	private function setUpdateUserFormView($message) {
		$this->setView(getViewByName("UpdateUserForm"));
		$this->getView()->setMessage($message, "alert-error");
	}

}

?>
