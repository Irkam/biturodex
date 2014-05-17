<?php
require_once(dirname(__FILE__) . "/db.class.php");

/**
 * 
 */
class Establishment{
	public $id;
	public $id_type;
	public $name;
	public $address0, $address1, $city, $postcode;
	public $latitude, $longitude;
	
	
	function __construct(){}
	
	
	/**
	 * TODO : sanitize
	 */
	public static function createEstablishment($name, $id_type, $address0, $address1, $city, $postcode, $lat, $lng){
		$establishment = new Establishment();
		
		$establishment->id_type = $id_type;
		$establishment->name = $name;
		$establishment->address0 = $address0;
		$establishment->address1 = $address1;
		$establishment->city = $city;
		$establishment->postcode = $postcode;
		$establishment->latitude = $lat;
		$establishment->longitude = $lng;
		
		return $establishment;
	}
	
	
	/**
	 * 
	 */
	public static function getEstablishmentById($id){
		if(is_null($id))
			return null;
		
		$db = new db();
		$query = $db->prepare("SELECT * FROM `establishment` WHERE `id_establishment` = ?");
		
		try{
			$query->execute(array($id));
			$res = $query->fetch(PDO::FETCH_ASSOC);
			
			$establishment = new Establishment();
			
			$establishment->id = $res['$id;'];
			$establishment->id_type = $res['$id_type;'];
			$establishment->name = $res['name;'];
			$establishment->address0 = $res['address0;'];
			$establishment->address1 = $res['address1;'];
			$establishment->city = $res['city;'];
			$establishment->postcode = $res['postcode;'];
			$establishment->latitude = $res['latitude;'];
			$establishment->longitude = $res['longitude;'];
			
			return $establishment;
		}catch(PDOException $e){
			return null;
		}
		
	}

	/**
	Renvoie le nom de la catégorie d'établissement sous forme de string
	*/
	public function getTypeNameString(){
		if(is_null($this->id_type))
			return null;
		
		$db = new db();
		$query = $db->prepare("SELECT `label_type` FROM `establishment_type` WHERE `id_type_establishment` = ?");
		
		try{
			$query->execute(array($this->id_type));
			$res = $query->fetch(PDO::FETCH_ASSOC);
			return json_encode($res['id_type_establishment']);
		}catch(PDOException $e){
			return false;
		}
	}
	
	/**
	Renvoie le nom de la catégorie d'établissement sous forme de string
	*/
	public static function getTypeNameStringById($type){
		if(is_null($type))
			return null;
		
		$db = new db();
		$query = $db->prepare("SELECT `label_type` FROM `establishment_type` WHERE `id_type_establishment` = ?");
		
		try{
			$query->execute(array($type));
			$res = $query->fetch(PDO::FETCH_ASSOC);
			return json_encode($res['id_type_establishment']);
		}catch(PDOException $e){
			return false;
		}
	}
	
	/**
	Renvoie une liste d'employés attachés à l'établissement
	*/
	public function getEmployees(){
		if(is_null($this->id))
			return null;
		
		$db = new db();
		$query = $db->prepare("SELECT `uid`, `id_establishment`, `rights`, `label` FROM `employees` WHERE `id_establishment` = ?");
		
		try{
			$query->execute(array($this->id));
			
			return json_encode($query->fetch(PDO::FETCH_ASSOC));
		}catch(PDOException $e){
			return false;
		}
	}
	
	/**
	 * TODO : vérifier que le type d'établissement existe avant d'executer (contrainte)
	 */
	public function addEstablishment() {
		$db = new db();
		$query = $db->prepare("INSERT INTO `establishment`(`id_type`, `name`, `address0`, `address1`, `city`, `postcode`, `latitude`, `longitude`) VALUES (?,?,?,?,?,?,?,?)");
		
		if ($query===false) return false;
		
		try{
			$query->execute(array($this->id_type, $this->name, $this->address0, $this->address1, $this->city, $this->postcode, $this->latitude, $this->longitude));
			$this->id = $db->lastInsertId();
		}catch(PDOException $e){
			return false;
		}
		
		return json_encode(array("error", $db->errorInfo()));
	}
	
	public function toJSON(){
		return json_encode(array(
			array("id", $this->id),
		));
	}
	
	public static function getLastEtablissement(){
		$db = new db();
		$query = $db->prepare('SELECT * FROM establishment ORDER BY id_establishement LIMIT 1');
		try{
			
			$query->execute(array($id));
			
			if($query->rowCount() > 0){
				
				$res = $query->fetch(PDO::FETCH_ASSOC);
				
				$establishment = new Establishment();
				
				$establishment->id = $res['$id;'];
				$establishment->id_type = $res['$id_type;'];
				$establishment->name = $res['name;'];
				$establishment->address0 = $res['address0;'];
				$establishment->address1 = $res['address1;'];
				$establishment->city = $res['city;'];
				$establishment->postcode = $res['postcode;'];
				$establishment->latitude = $res['latitude;'];
				$establishment->longitude = $res['longitude;'];
				
				return $establishment;
			}else{
				return array(null);
			}
		
			
		}catch(PDOException $e){
			echo json_encode(array("error", $db->errorInfo()));
			return NULL;
		}
	}
	
	public static function getEtablissementByIdRanged($idEtablissement, $rangeSize=30){
		$db = new db();
		if($idEtablissement == null){
			$query = $db->execute('SELECT * FROM establishment ORDER BY id_establishement LIMIT 1');
		}else{
			$query = $db->execute('SELECT * FROM establishment WHERE id_establishement= '.$idEtablissement.'  ORDER BY id_establishement LIMIT 1');
		}
		
		try{
			
			$query->execute(array($id));
			
			if($query->rowCount() > 0){
				
				$res = $query->fetch(PDO::FETCH_ASSOC);
				
				$establishment = new Establishment();
				
				$establishment->id = $res['$id;'];
				$establishment->id_type = $res['$id_type;'];
				$establishment->name = $res['name;'];
				$establishment->address0 = $res['address0;'];
				$establishment->address1 = $res['address1;'];
				$establishment->city = $res['city;'];
				$establishment->postcode = $res['postcode;'];
				$establishment->latitude = $res['latitude;'];
				$establishment->longitude = $res['longitude;'];
				
				array_push($establishment, $establishment);
			}else{
				return array(null);
			}
		

		}catch(PDOException $e){
			return json_encode(array("error", $db->errorInfo()));
			return NULL;
		}
	}

}
?>
