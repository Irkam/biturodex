<form method="post" action="index.php?action=searchResult" class="modal">
	<div class="modal-header">
		<h3 style="text-align:center">Résultat de votre demande</h3>
	</div>
	<div class="form-horizontal modal-body">
		<?php	if ($this->message!=="")
			echo '<div class="alert '.$this->style.'">'.$this->message.'</div>';
		?>
		
		<?php
			while($data=mysql_fetch_assoc($_SESSION)) {
			echo "{$data["name"]}";
			echo "{$data["begins"]}>";
			echo "{$data["ends"]}>";
			echo "{$data["address"]}>";
			
			}
		?>
		azert
		</div> <!-- Fin du formulaire -->
		
</form>