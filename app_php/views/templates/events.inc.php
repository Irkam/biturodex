<?php
?>
<li class="media well">
	<div class="media-body">
		<h4 class="media-heading">Événements de <?php $events->getOwner(); ?></h4>
		<br>
	  	
	  	<div>
	  		<ul>
	  			<?php foreach($events as $event) {
	  				echo("<li> <?php echo($eventName); ?> </li>");
	  			} ?>
	  		</ul>
	  	</div>
	</div>
</li>
<?php
?>


