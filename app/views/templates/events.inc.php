
<li class="media well">
	<div class="media-body">
		<h4 class="media-heading">Événements de <? $events->getOwner(); ?></h4>
		<br>
	  	
	  	<div>
	  		<ul>
	  			<? foreach($events as $event) {
	  				echo("<li> <? echo($eventName); ?> </li>");
	  			} ?>
	  		</ul>
	  	</div>
	</div>
</li>


