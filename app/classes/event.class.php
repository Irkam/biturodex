<?php
require_once(dirname(__FILE__) . "/db.class.php");

/**
 * 
 */
class Event{
	public $id;
	public $name;
	public $type;
	public $op;
	public $latitude, $longitude, $radius, $establishment, $address;
	public $timestamp_start, $timestamp_end;
	
	/**
	 * Fetches an event by its id
	 */
	public static function getEventById($id) {
		$db = new db();
		
		$stmt = $db->prepare("SELECT * FROM event WHERE id_event = :id");
		$stmt->bindParam('id', $id);
		
		try{
			$stmt->execute(array($id));
			
			$res = $stmt->fetch(PDO::FETCH_ASSOC);
			$event = new Event();
			
			$event->id = $res['id'];
			$event->name = $res['name'];
			$event->type = $res['id_type'];
			$event->op = $res['op'];
			$event->establishment = $res['id_establishment'];
			$event->latitude = $res['latitude'];
			$event->longitude = $res['longitude'];
			$event->radius = $res['radius'];
			$event->address = $res['address'];
			$event->timestamp_start = $res['starts'];
			$event->timestamp_end = $res['ends'];
			
			return $event;
			
		}catch(PDOException $e){
			echo json_encode(array("error", $e->getMessage()));
			return null;
		}
	}
	
	/**
	 * Creates an event from scratch
	 */
	public static function createEvent($name, $type, $op, $lat, $lng, $rad, $address=null, $estab=null, $starts, $ends){
		$event = new Event();
		
		$event->name = $name;
		$event->type = $type;
		$event->op = $op;
		$event->establishment = $estab;
		$event->latitude = $lat;
		$event->longitude = $lng;
		$event->radius = $rad;
		$event->address = $address;
		$event->timestamp_start = $starts;
		$event->timestamp_end = $ends;
		
		return $event;
	}
	
	function __construct(){}
	
	
	public function addEvent($name, $own_uid, $id_establishment, $latitude, $longitude, $radius, $begins, $ends, $id_type, $address) {
		/* $this->connection->beginTransaction(); */
		
		/*
		$this->connection->exec("CREATE TABLE IF NOT EXISTS event(id_event integer primary key auto_increment, 
																  name char(64), 
																  owner_uid integer, 
																  id_establishment integer, 
																  latitude double, 
																  longitude double, 
																  radius int, 
																  begins datetime, 
																  ends datetime, 
																  id_type integer, 
																  address char(250), 
																 )");
		*/
		
		/* ici, les fonctions de vérification de la validité du contenu des variables */
		$query = $this->connection->prepare("INSERT INTO event(name, own_uid, id_establishment, latitude, longitude, radius, begins, ends, id_type, address) VALUES (?,?,?,?,?,?,?,?,?,?)");
		if ($query===false) { $this->connection->rollback(); return false; }
		$res = $query->execute(array($name, $own_uid, $id_establishment, $latitude, $longitude, $radius, $begins, $ends, $id_type, $address));
		if ($res === false) { $this->connection->rollback(); return false; }
	}
	
	
	/**
	 * @return string JSON encoded object
	 */
	public function toJSON(){
		return json_encode(array(
			array("id", $this->id),
			array("name", $this->name),
			array("type", $this->type),
			array("op", $this->op),
			array("establishment", $this->establishment),
			array("lat", $this->latitude),
			array("lng", $this->longitude),
			array("rad", $this->radius),
			array("address", $this->address),
			array("starts", $this->timestamp_start),
			array("ends", $this->timestamp_end),
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
}


?>