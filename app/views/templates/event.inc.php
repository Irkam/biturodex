<div>
	<div><p><?php echo $event->name;?></p></div>
	<?php
		//Affichage du bouton d'inscription
		if(!is_null($user)){
			?>
			<div>
				<p>Participation à l'événement</p>
				<span class="btn success" action="updateEventSubscribe(<?php echo $user->uid . ", " . $user->sesstoken . ", " . $event->id . ", " . strval(Event::PARTICIPATION_YES);?>)">Oui</span>
				<span class="btn info" action="updateEventSubscribe(<?php echo $user->uid . ", " . $user->sesstoken . ", " . $event->id . ", " . strval(Event::PARTICIPATION_MAYBE);?>)">Peut-être</span>
				<span class="btn warning" action="updateEventSubscribe(<?php echo $user->uid . ", " . $user->sesstoken . ", " . $event->id . ", " . strval(Event::PARTICIPATION_NO);?>)">Non</span>
			</div>
			<?php
		}
	?>
</div>