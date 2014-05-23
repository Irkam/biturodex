<?php

require_once("actions/Action.inc.php");
require_once(dirname(__FILE__)."/../classes/event.class.php");

class ShowEventAction extends Action {
	public function run() {
		$uname = $_SESSION['login'];
		if(isset($_GET['eid'])){
			$id_event = intval($_GET['eid']);
			$event = Event::getEventById($id_event);
			
			if (is_null($event)) {
				$this->setMessageAndEvent("Evenement introuvable", null);
			}else{
				$this->setMessageAndEvent("", $event);
			}
		}else{
			$this->setMessageAndEvent("Evenement introuvable", null);
		} 
	}
	
	private function setMessageAndEvent($message, $events) {
		$this->setView(getViewByName("Event"));
		$this->getView()->setMessage($message, "alert-error");
		$this->getView()->setEvent($events);
	}
}

?>
