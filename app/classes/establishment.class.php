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
	 * fonction permettant de retrouver un Etablisssement par son id
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
	 * fonction permettant d'obtenir les derniers Etablissements entré dans la bdd
	 */
	public static function getLastEstablishment(){
		$db = new db();
		$query = $db->prepare('SELECT * FROM `establishment` ORDER BY `id_establishment` LIMIT 1');
		try{
			
			$query->execute();
			
			if($query->rowCount() > 0){
				
				$res = $query->fetch(PDO::FETCH_ASSOC);
				
				$establishment = new Establishment();
				
				$establishment->id = $res['id_establishment'];
				$establishment->id_type = $res['id_type'];
				$establishment->name = $res['name'];
				$establishment->address0 = $res['address0'];
				$establishment->address1 = $res['address1'];
				$establishment->city = $res['city'];
				$establishment->postcode = $res['postcode'];
				$establishment->latitude = $res['latitude'];
				$establishment->longitude = $res['longitude'];
				
				return $establishment;
			}else{
				return array(null);
			}
		
			
		}catch(PDOException $e){
			echo json_encode(array("error", $db->errorInfo()));
			return NULL;
		}
	}
	
	/**
	 * fonction permettant d'obtenir les derniers Etablissements entré dans la bdd
	 * à partir de l'id et retourne les 30 derniers establissements suivant
	 */
	public static function getEstablishmentsByIdRanged($firstId, $rangeSize=30){
		if($rangeSize <= 1)
			return array(Establishment::getLastEstablishment());
		
		if($firstId == null || $firstId < 1)
			$firstId = Establishment::getLastEstablishment()->getId();
		
		$db = new db();
		
		$query = $db->prepare('SELECT * FROM `establishment` 
			WHERE `id_establishment` <= :id  ORDER BY `id_establishment` LIMIT 0, :range');
		
		$query->bindParam(":id", $firstId, PDO::PARAM_INT);
		$query->bindParam(":range", $rangeSize, PDO::PARAM_INT);
		
		try{
			$query->execute();
			
			if($query->rowCount() > 0){
				$responses = $query->fetchAll(PDO::FETCH_ASSOC);
				$establishments = array();
				
				foreach($responses as $res){
					$establishment = new Establishment();
					
					$establishment->id = $res['id_establishment'];
					$establishment->id_type = $res['id_type'];
					$establishment->name = $res['name'];
					$establishment->address0 = $res['address0'];
					$establishment->address1 = $res['address1'];
					$establishment->city = $res['city'];
					$establishment->postcode = $res['postcode'];
					$establishment->latitude = $res['latitude'];
					$establishment->longitude = $res['longitude'];
					
					array_push($establishments, $establishment);
				}
				
				return $establishments;
			}else{
				return array(null);
			}
		

		}catch(PDOException $e){
			return json_encode(array("error", $db->errorInfo()));
			return NULL;
		}
	}

	public static function getEstablishmentsByLatLngDistType($lat, $lng, $dist, $type, $queryrange=30){
		$db = new db();
		
		$stmt = $db->prepare("SELECT `id_establishment`, `id_type`, `name`, `address0`, `address1`, `city`, `postcode`, `latitude`, `longitude`, get_distance(:lat,:lng,`latitude`,`longitude`) as dist 
		FROM `establishment`   
		WHERE get_distance(:lat,:lng,`latitude`,`longitude`) <= :dist
		AND `id_type`=:type
		ORDER BY dist
		LIMIT 0,:range");
		$stmt->bindParam(":lat", $lat, PDO::PARAM_INT);
		$stmt->bindParam(":lng", $lng, PDO::PARAM_INT);
		$stmt->bindParam(":dist", $dist, PDO::PARAM_INT);
		$stmt->bindParam(":type", $type, PDO::PARAM_INT);
		$stmt->bindParam(":range", $queryrange, PDO::PARAM_INT);
		
		try{
			$stmt->execute();
			
			if($stmt->rowCount() > 0){
				$responses = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$establishments = array();
				
				foreach($responses as $res){
					$establishment = new Establishment();
					
					$establishment->id = $res['id_establishment'];
					$establishment->id_type = $res['id_type'];
					$establishment->name = $res['name'];
					$establishment->address0 = $res['address0'];
					$establishment->address1 = $res['address1'];
					$establishment->city = $res['city'];
					$establishment->postcode = $res['postcode'];
					$establishment->latitude = $res['latitude'];
					$establishment->longitude = $res['longitude'];
					
					array_push($establishments, $establishment);
				}
				
				return $establishments;
			}else
				return array(null);
		}catch(PDOException $e){
			throw $e;
			return null;
		}
	}

	public static function getEstablishmentsByPostcode($postcode, $queryrange=30){
		$db = new db();
		
		$stmt = $db->prepare("SELECT * 
		FROM `establishment`   
		WHERE `postcode`=:postcode
		AND `id_type`=:type
		ORDER BY dist
		LIMIT 0,:range");
		$stmt->bindParam(":postcode", $postcode);
		
		try{
			$stmt->execute();
			
			if($stmt->rowCount() > 0){
				$responses = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$establishments = array();
				
				foreach($responses as $res){
					$establishment = new Establishment();
					
					$establishment->id = $res['id_establishment'];
					$establishment->id_type = $res['id_type'];
					$establishment->name = $res['name'];
					$establishment->address0 = $res['address0'];
					$establishment->address1 = $res['address1'];
					$establishment->city = $res['city'];
					$establishment->postcode = $res['postcode'];
					$establishment->latitude = $res['latitude'];
					$establishment->longitude = $res['longitude'];
					
					array_push($establishments, $establishment);
				}
				
				return $establishments;
			}else
				return array(null);
		}catch(PDOException $e){
			throw $e;
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
	
	public function getId(){return $this->id;}

}
?>
