<?php
require_once(dirname(__FILE__) . "/db.class.php");

/**
 * 
 */
class StatEntry{
	public $statEntryId;
	public $statEmitterUID;
	public $rating;
	public $comment;
}

class UserStatEntry extends StatEntry{
	public $statTargetUID;
}

class EstablishmentStatEntry extends StatEntry{
	public $statTargetEst;

}

class EventStatEntry extends StatEntry{
	public $statTargetEvent;

}

?>
