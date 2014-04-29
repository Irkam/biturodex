<?php
require_once(dirname(__FILE__) . "/db.class.php");

/**
 * 
 */
class Establishment{
	public $idEst;
	public $establishmentName;
	public $typeId;

	/**
	Renvoie le nom de la catégorie d'établissement sous forme de string
	*/
	public function getTypeName(){
	}
	
	/**
	Renvoie une liste d'employés attachés à l'établissement
	*/
	public function getEmployees(){
	}
	
	public function addEstablishment($id_type, $name, $address0, $address2, $city, $postcode, $latitude, $longitude) {
		/*
		$this->connection->exec("CREATE TABLE IF NOT EXISTS establishment(id_establishment integer primary key auto_increment, 
																		  id_type integer, 
																		  name char(60), 
																		  address0 char(60), 
																		  address2 char(60), 
																		  city char(30), 
																		  postcode char(6), 
																		  latitude double, 
																		  longitude double
																		 )");
		*/
		$query = $this->connection->prepare("INSERT INTO establishment($id_type, $name, $address0, $address2, $city, $postcode, $latitude, $longitude) VALUES (?,?,?,?,?,?,?,?)");
		if ($query===false) { $this->connection->rollback(); return false; }
		$res = $query->execute(array($id_type, $name, $address0, $address2, $city, $postcode, $latitude, $longitude));
		if ($res === false) { $this->connection->rollback(); return false; }
	}

}
?>
