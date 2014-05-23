<?php function generateSearchNormal(){
	$searchstring = $_POST['keyword'];
		$keywords = preg_split("/\s+/", $searchstring);
	$events = Event::getEventsByName($keywords);
	?>
	<div class="control-group">

			<?php
			foreach($events as $event){
				
					echo("<tr><td> Nom soirée : " . $event->name .  "</td><td> Début de la soirée : " . $event->begins . "</td></tr><br>");
				
			}
			?>
		
	</div>
	<?php
} 




function generateSearchUser() {
	$searchstring = $_POST['keyword'];
		$keywords = preg_split("/\s+/", $searchstring);
	$events = Event::getEventsByName($keywords);
	?>
	<div class="control-group">

			<?php
			if(sizeof($events) > 0)
				foreach($events as $event){
					
						echo("<tr><td> Nom soirée : " . $event->name .  "</td><td> Début de la soirée : " . $event->begins . "</td></tr><br>");
					
				}
			else {
				echo("<tr><td>Aucune correspondance trouvée pour la recherche.</td></tr>");
			}
			?>
		
	</div>
	<?php
} 


?>

<form method="post" action="index.php?action=searchResult" class="modal">
	<div class="modal-header">
		<h3 style="text-align:center">Résultat de votre demande</h3>
	</div>
	<div class="form-horizontal modal-body">
		<?php	/*if ($this->message!=="")
			echo '<div class="alert '.$this->style.'">'.$this->message.'</div>';*/
		?>
		
		<?php
		
			
		if($_SESSION['login'] == null){
			generateSearchNormal();
		}else{
			generateSearchUser();
		}
		
		?>
		
		</div> <!-- Fin du formulaire -->
</form>