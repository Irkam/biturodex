<?php
//var_dump($event);
//var_dump($user);
?>
<div><br></div><div><br></div><div><br></div><div><br></div><div><br></div><div><br></div><div><br></div><div><br></div><div><br></div><div><br></div><div><br></div>
<div class="modal-header"><p><?php echo $event->name;?></p></div>
<div class="form-horizontal modal-body">
<?php
	//Affichage du bouton d'inscription
	if(!is_null($user)){
		?>
		
			<div class="control-group">
			<p>Participation à l'événement</p>
				<span class="btn success" action="updateEventSubscribe(<?php echo $user->uid . ", " . $event->id . ", " . strval(Event::PARTICIPATION_YES);?>)">Oui</span>
				<span class="btn info" action="updateEventSubscribe(<?php echo $user->uid . ", " . $event->id . ", " . strval(Event::PARTICIPATION_MAYBE);?>)">Peut-être</span>
				<span class="btn warning" action="updateEventSubscribe(<?php echo $user->uid . ", " . $event->id . ", " . strval(Event::PARTICIPATION_NO);?>)">Non</span>
			<div class="control-group">
		
		<?php
	}
?>
</div>