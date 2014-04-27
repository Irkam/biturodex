<?php

public class StatEntry{
	public $statEntryId;
	public $statEmitterUID;
	public $rating;
	public $comment;
}

public class UserStatEntry extends StatEntry{
	public $statTargetUID;
}

public class EstablishmentStatEntry extends StatEntry{
	public $statTargetEst;

}

public class EventStatEntry extends StatEntry{
	public $statTargetEvent;

}

?>
