<?php

require_once(dirname(__FILE__) . "/Action.inc.php");
require_once(dirname(__FILE__) . "/../classes/establishment.class.php");

class CreateEstablishmentAction extends Action {

	/**
	* Traite les données envoyées par le formulaire de création d'événement.
	*
	* Si l'utilisateur n'est pas connecté, un message lui demandant de se connecter est affiché.
	*
	* Sinon, la fonction ajoute l'événement à la base de données.
	*
	* Après validation, l'un des messages suivants est affiché à l'utilisateur :
	* - "Le remplissage des champs marqués d'un * est obligatoire.";
	* - "Votre événement a bien été créé.".
	* 
	* @see Action::run()
	*/
	/*public function run() {
	$owner = $this->getSessionLogin();
	if($owner == null) { setMessageView("Vous n'êtes pas connecté"); return; }
	
	$establishmentName = &$_POST['establishmentName'];
	$establishmentType = "";
	$address0 = &$_POST['address0'];
	$address2 = &$_POST['address2'];
	$postcode = &$_POST['postcode'];
	$city = &$_POST['city'];
	
	if (empty($establishmentName) || empty($address0) || empty($postcode) || empty($city)) { // empty($establishmentType) aussi
	$this->setCreateEstablishmentFormView("Le remplissage des champs marqués d'un * est obligatoire.");
	return;
	}
	$establishment = new Establishment($establishmentName, $establishmentType, $address0, $address2, $postcode, $city);
	$result = $this->database->AddEstablishment($establishment);
	
	if (!$result) {
	$this->setCreateEstablishmentFormView("Impossible de créer votre établissement.");
	return;
	}
	
	$this->setMessageView("Votre établisement a été créé avec succès.");
	}*/
	
	public function run() {
		$establishmentName = $_POST['establishmentName'];
		// $id_type = $_POST['establishmentType']; // NE FONCTIONNERA PAS
		$id_type = 1;
		$address0 = $_POST['address0'];
		$address1 = $_POST['address1'];
		$city = $_POST['city'];
		$postcode = $_POST['postcode'];
		$lat = 1; // à remplacer par la vraie latitude
		$lng = 1; // à remplacer par la vraie longitude
		$establishment = Establishment::createEstablishment($establishmentName, $id_type, $address0, $address1, $city, $postcode, $lat, $lng);
		$res = $establishment->addEstablishment();
		
		if (!is_null($res)) {
			$this->setCreateEstablishmentFormView($res);
			$this->setMessageView("Votre établissement a bien été créé");
		} else $this->setCreateEstablishmentFormView($res);	
	}
	
	private function setCreateEstablishmentFormView($message) {
		$this->setView(getViewByName("CreateEstablishmentForm"));
		$this->getView()->setMessage($message, "alert-error");
	}
}

?>