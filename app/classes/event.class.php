<?php
require_once(dirname(__FILE__) . "/db.class.php");

/**
 * 
 */
class Event{
	public $id;
	public $name;
	public $id_type;
	public $own_uid;
	public $latitude, $longitude, $radius, $id_establishment, $address;
	public $begins, $ends;
	
	const ORDER_SOONEST = 0;
	const ORDER_NEAREST = 1;
	
	/**
	 * Fetches an event by its id
	 */
	public static function getEventById($id) {
		$db = new db();
		
		$stmt = $db->prepare("SELECT * FROM event WHERE id_event = :id");
		$stmt->bindParam('id', $id);
		
		try{
			$stmt->execute();			
			if($stmt->rowCount() > 0){
				$res = $stmt->fetch(PDO::FETCH_ASSOC);
				$event = new Event();
				
				$event->id = $res['id_event'];
				$event->name = $res['name'];
				$event->id_type = $res['id_type'];
				$event->own_uid = $res['owner_uid'];
				$event->id_establishment = $res['id_establishment'];
				$event->latitude = $res['latitude'];
				$event->longitude = $res['longitude'];
				$event->radius = $res['radius'];
				$event->address = $res['address'];
				$event->begins = $res['begins'];
				$event->ends = $res['ends'];
				
				return $event;
			}else{
				return array(null);
			}
			
		}catch(PDOException $e){
			echo json_encode(array("error", $e->getMessage()));
			return null;
		}
	}
	
	/**
	 * fonction permettant d'obtenir les derniers Evenements entré dans la bdd
	 */
	public static function getLastEvent(){
		$db = new db();
		$query = $db->prepare("SELECT * FROM `event` ORDER BY `id_event` DESC LIMIT 1");
		
		try{
			$query->execute();		
			if($query->rowCount() > 0){
				$res = $query->fetch(PDO::FETCH_ASSOC);
				$event = new Event();
				
				$event->id = $res['id_event'];
				$event->name = $res['name'];
				$event->id_type = $res['id_type'];
				$event->own_uid = $res['owner_uid'];
				$event->id_establishment = $res['id_establishment'];
				$event->latitude = $res['latitude'];
				$event->longitude = $res['longitude'];
				$event->radius = $res['radius'];
				$event->address = $res['address'];
				$event->begins = $res['begins'];
				$event->ends = $res['ends'];
				
				return $event;
			}else{
				return array(null);
			}
		}catch(PDOException $e){
			echo json_encode(array("error", $e->getMessage()));
			return null;
		}
	}
	
	/**
	 * fonction permettant d'obtenir les derniers Evenements entré dans la bdd
	 * à partir de l'id et retourne les 30 derniers evenements suivant
	 */
	public static function getEventsByIdRanged($firstId, $rangesize=30){
		if($rangesize <= 1)
			return array(Event::getLastEvent());
		
		$db = new db();
		$stmt = $db->prepare("SELECT * FROM `event` WHERE `id_event` <= :id ORDER BY `id_event` DESC LIMIT 0, :range");
		$stmt->bindParam(":id", $firstId, PDO::PARAM_INT);
		$stmt->bindParam(":range", $rangesize, PDO::PARAM_INT);
		
		try{
			$stmt->execute();			
			
			if($stmt->rowCount() > 0){
				$response = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$events = array();
				
				foreach($response as $res){
					$event = new Event();
					
					$event->id = $res['id_event'];
					$event->name = $res['name'];
					$event->id_type = $res['id_type'];
					$event->own_uid = $res['owner_uid'];
					$event->id_establishment = $res['id_establishment'];
					$event->latitude = $res['latitude'];
					$event->longitude = $res['longitude'];
					$event->radius = $res['radius'];
					$event->address = $res['address'];
					$event->begins = $res['begins'];
					$event->ends = $res['ends'];
					
					array_push($events, $event);
				}
				
				return $events;
			}else{
				return array(null);
			}
		}catch(PDOException $e){
			echo json_encode(array("error", $e->getMessage()));
			return null;
		}
	}

	/**
	 * TODO : ajout type
	 */
	public static function getEventsByDateTimeRangeLatLngDist($fromtime, $totime, $lat, $lng, $dist, 
	$queryrange=30, $orderpriority=Event::ORDER_SOONEST){
		$db = new db();
		
		$stmt = $db->prepare("SELECT `id_event`, `name`, `owner_uid`, `id_establishment`, `latitude`, `longitude`, `radius`, `begins`, `ends`, `id_type`, `address`, get_distance(:lat,:lng,`latitude`,`longitude`) as dist  
		FROM `event` 
		WHERE `begins`>=:fromtime AND `ends`<=:totime 
		AND get_distance(:lat,:lng,`latitude`,`longitude`) <= :dist 
		ORDER BY :order 
		LIMIT 0,:range");
		$stmt->bindParam(":fromtime", $fromtime, PDO::PARAM_INT);
		$stmt->bindParam(":totime", $totime, PDO::PARAM_INT);
		$stmt->bindParam(":lat", $lat, PDO::PARAM_INT);
		$stmt->bindParam(":lng", $lng, PDO::PARAM_INT);
		$stmt->bindParam(":dist", $dist, PDO::PARAM_INT);
		$stmt->bindParam(":range", $queryrange, PDO::PARAM_INT);
		
		switch ($orderpriority) {
			case Event::ORDER_SOONEST:
				$order = "begins";
				$stmt->bindParam(":order", $order);
				break;
			case Event::ORDER_NEAREST:
				$order = "dist";
				$stmt->bindParam(":order", $order);
				break;
			default:
				$stmt->bindParam(":order", "begins");
				break;
		}
		
		try{
			$stmt->execute();
			
			if($stmt->rowCount() > 0){
				$responses = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$events = array();
				
				foreach($responses as $res){
					$event = new Event();
					
					$event->id = $res['id_event'];
					$event->name = $res['name'];
					$event->id_type = $res['id_type'];
					$event->own_uid = $res['owner_uid'];
					$event->id_establishment = $res['id_establishment'];
					$event->latitude = $res['latitude'];
					$event->longitude = $res['longitude'];
					$event->radius = $res['radius'];
					$event->address = $res['address'];
					$event->begins = $res['begins'];
					$event->ends = $res['ends'];
					
					array_push($events, $event);
				}
				
				return $events;
			}else
				return array(null);
		}catch(PDOException $e){
			throw $e;
			return null;
		}
	}

	public static function getEventsByDateTimeRangeLatLngDistType($fromtime, $totime, $lat, $lng, $dist, $type,
	$queryrange=30, $orderpriority=Event::ORDER_SOONEST){
		$db = new db();
		
		$stmt = $db->prepare("SELECT `id_event`, `name`, `owner_uid`, `id_establishment`, `latitude`, `longitude`, `radius`, `begins`, `ends`, `id_type`, `address`, get_distance(:lat,:lng,`latitude`,`longitude`) as dist  
		FROM `event` 
		WHERE `begins`>=:fromtime AND `ends`<=:totime 
		AND get_distance(:lat,:lng,`latitude`,`longitude`) <= :dist 
		AND `type`=:type
		ORDER BY :order 
		LIMIT 0,:range");
		$stmt->bindParam(":fromtime", $fromtime, PDO::PARAM_INT);
		$stmt->bindParam(":totime", $totime, PDO::PARAM_INT);
		$stmt->bindParam(":lat", $lat, PDO::PARAM_INT);
		$stmt->bindParam(":lng", $lng, PDO::PARAM_INT);
		$stmt->bindParam(":dist", $dist, PDO::PARAM_INT);
		$stmt->bindParam(":type", $type, PDO::PARAM_INT);
		$stmt->bindParam(":range", $queryrange, PDO::PARAM_INT);
		
		switch ($orderpriority) {
			case Event::ORDER_SOONEST:
				$order = "begins";
				$stmt->bindParam(":order", $order);
				break;
			case Event::ORDER_NEAREST:
				$order = "dist";
				$stmt->bindParam(":order", $order);
				break;
			default:
				$stmt->bindParam(":order", "begins");
				break;
		}
		
		try{
			$stmt->execute();
			
			if($stmt->rowCount() > 0){
				$responses = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$events = array();
				
				foreach($responses as $res){
					$event = new Event();
					
					$event->id = $res['id_event'];
					$event->name = $res['name'];
					$event->id_type = $res['id_type'];
					$event->own_uid = $res['owner_uid'];
					$event->id_establishment = $res['id_establishment'];
					$event->latitude = $res['latitude'];
					$event->longitude = $res['longitude'];
					$event->radius = $res['radius'];
					$event->address = $res['address'];
					$event->begins = $res['begins'];
					$event->ends = $res['ends'];
					
					array_push($events, $event);
				}
				
				return $events;
			}else
				return array(null);
		}catch(PDOException $e){
			throw $e;
			return null;
		}
	}
	
	/**
	 * Recherche des événements comprenant tout ou une partie du mot clé
	 * 
	 * Ne fonctionne pas encore correctement avec les accents. Peut-être à cause de l'encodage
	 * de la bdd
	 * 
	 * @param keyword string ou array
	 * @return array(Event)
	 */
	public static function getEventsByName($keyword, $limitbegin=0, $limitend=30){
		$db = new db();
		
		if(is_array($keyword)){
			$q = "SELECT * FROM `event` WHERE `name`";
			
			for($i = 0 ; $i < count($keyword) ; $i++){
				if(strlen($keyword[$i]) == 0){
					unset($keyword[$i]);
					continue;
				}
				
				$keyword[$i] = "%$keyword[$i]%";
				$q .= " LIKE ?";
				if($i != count($keyword) - 1){
					$q .= " OR";
				}
			}
			
			//array_push($keyword, $limitbegin);
			//array_push($keyword, $limitend);
			$stmt = $db->prepare($q);
			
			if(count($keyword) == 0){
				return array(null);
			}
			
			try{
				$stmt->execute($keyword);
				
				if($stmt->rowCount() > 0){
					$response = $stmt->fetchAll(PDO::FETCH_ASSOC);
					
					$events = array();
					foreach($response as $res){
						$event = new Event();
						
						$event->id = $res['id_event'];
						$event->name = $res['name'];
						$event->id_type = $res['id_type'];
						$event->own_uid = $res['owner_uid'];
						$event->id_establishment = $res['id_establishment'];
						$event->latitude = $res['latitude'];
						$event->longitude = $res['longitude'];
						$event->radius = $res['radius'];
						$event->address = $res['address'];
						$event->begins = $res['begins'];
						$event->ends = $res['ends'];
						
						array_push($events, $event);
					}
					
					return $events;
				}else{
					return array(null);
				}
			}catch(PDOException $e){
				echo($e->getError());
				return null;
			}
		}else{
			$stmt = $db->prepare("SELECT * FROM `event` WHERE `name` LIKE ?");
			
			if(strlen($keyword) == 0)
					return array(null);
						
			try{
				$stmt->execute(array("%$keyword%"));
				
				if($stmt->rowCount() > 0){
					$response = $stmt->fetchAll(PDO::FETCH_ASSOC);
					
					$events = array();
					foreach($response as $res){
						$event = new Event();
						
						$event->id = $res['id_event'];
						$event->name = $res['name'];
						$event->id_type = $res['id_type'];
						$event->own_uid = $res['owner_uid'];
						$event->id_establishment = $res['id_establishment'];
						$event->latitude = $res['latitude'];
						$event->longitude = $res['longitude'];
						$event->radius = $res['radius'];
						$event->address = $res['address'];
						$event->begins = $res['begins'];
						$event->ends = $res['ends'];
						
						array_push($events, $event);
					}
					
					return $events;
				}else{
					return array(null);
				}
			}catch(PDOException $e){
				echo($e->getError());
				return null;
			}
		}
	}
	
	public static function getTypes(){		
		$db = new db();
		$query = $db->prepare("SELECT * FROM `event_type`");
		
		try{
			$query->execute();
			$res = $query->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}catch(PDOException $e){
			throw $e;
		}
		
		return null;
	}
	
	/**
	 * Creates an event from scratch
	 */
	public static function createEvent($name, $type, $own_uid, $lat, $lng, $rad, $address=null, $estab=null, $starts, $ends){
		$event = new Event();
		
		$event->name = $name;
		$event->id_type = $type;
		$event->own_uid = $own_uid;
		$event->id_establishment = $estab;
		$event->latitude = $lat;
		$event->longitude = $lng;
		$event->radius = $rad;
		$event->address = $address;
		$event->begins = $starts;
		$event->ends = $ends;
		
		return $event;
	}
	
	function __construct(){}
	
	
	public function addEvent() {
		/* ici, les fonctions de vérification de la validité du contenu des variables */
		$db = new db();
		
		$query = $db->prepare("	INSERT INTO `event`(`name`, `owner_uid`, `id_establishment`, `latitude`, `longitude`, `radius`, `begins`, `ends`, `id_type`, `address`) 
								VALUES (?,?,?,?,?,?,?,?,?,?)");
		if ($query===false) { $this->connection->rollback(); return false; }
		
		try{
			$query->execute(array($this->name, $this->own_uid, $this->id_establishment, $this->latitude, $this->longitude, $this->radius, $this->begins, $this->ends, $this->id_type, $this->address));
			$this->id = $db->lastInsertId();
			return $this;
		}catch(PDOException $e){
			throw $e;
		}
		
		return null;
	}
	
	
	/**
	 * @return string JSON encoded object
	 */
	public function toJSON(){
		return json_encode(array(
			array("id", $this->id),
			array("name", $this->name),
			array("type", $this->id_type),
			array("own_uid", $this->own_uid),
			array("id_establishment", $this->id_establishment),
			array("lat", $this->latitude),
			array("lng", $this->longitude),
			array("rad", $this->radius),
			array("address", $this->address),
			array("starts", $this->begins),
			array("ends", $this->ends),
		));
	}
	
	/*
	suppression de l'evenement
	soit date de fin de l'event
	*/
	public function remove_event_by_date(){
		$today = date("Y-m-d H:i:s");   
		$req = "DELETE FROM event WHERE ends < '$today' " ;
		$rs = Database::$connection->prepare($req);
		$rs->execute();
	}
	
	/*
	bloquer l'event pour qu'il n'y ait plus d'utilisateur qui puissent
	participer à l'event 
	*/
	public function block_event($id_event){
		$today = date("Y-m-d H:i:s"); 
		$req = "SELECT id_event FROM event WHERE begins = '$today' AND id_event = '$id_event' ";
		$rs = Database::$connection->query($req);
		$ligne = $rs->fetch(PDO::FETCH_ASSOC);
		if($ligne != null){
			return true;
		}else{
			return false;
		}
	}
	
	
	/* supprimer un événement en fonction de la volonté de owner_uid */
	public function removeEventByUser($id_suppresser, $id_event) {
		$request = $this->connection->prepare("SELECT owner_uid from EVENT where id_event = ?;");
		if ($request===false) return false;
		if (!$request->execute(array($id_event))) return false;
		
		$owner_uid = $request;
		/* attention, bien vérifier que les types sont identiques (retour du getter) pour mettre un === */
		if($id_suppresser == $owner_uid){
			$request = $this->connection->prepare("DELETE * from EVENT where owner_uid = ?;");
			if ($request===false) return false;
			if (!$request->execute(array($owner_uid))) return false;
			return true;
		}
		else return false; /* contre les injections, owner_uid et id_suppresser ne correspondent pas. */
	}
	
	public function getId(){return $this->id;}
	public function getName(){return $this->name;}
}


?>