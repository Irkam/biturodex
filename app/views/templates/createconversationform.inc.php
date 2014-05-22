<?php function generateUser() { ?>
	<script type='text/javascript' src='script_js/js.js'></script>
	<label id="bidon" for=conversationIdType">Choix de l'utilisateur<select>
		<option id="1" value="bar" selected>Bart</option>
		<option id="2" value="cinema">Cina</option>
		<option id="3" value="nightclub">Bob</option>
		<option id="4" value="outside">Lionel</option>
	</select></label><br> 
	<input type="button" name="ajout" value="Ajout" onclick="ajoutUser()" />
	<select size="3" id="affiche">
  		<option>Option 0</option>
  		<option>Option 1</option>
	</select>
	<?php
} 

// input pour le titre/nom, l'input la plus importante !
// il faut normalement s'assurer que $for $label et $name ne soient pas vides (ce n'est pas g�nant pour $placeHolder)
function generateFirst($name) { ?>
	<div class="control-group">
			<label class="control-label" for="<?php echo($name); ?>">Créer une conversation</label>	
		</div>
		<br> <?php
}
?>

<form method="post" action="index.php?action=AddSurvey" class="modal">
	<div class="modal-header">
		<h3 style="text-align:center">Création d'une Conversation</h3>
	</div>
	<div class="form-horizontal modal-body">
		<?php	if ($this->message!=="")
			echo '<div class="alert '.$this->style.'">'.$this->message.'</div>';
		?>
		
		<?php 
		generateFirst("conversationName");
		generateUser();
		 ?>
		<!-- latitude et longitude à gérer -->
		
		</div> <!-- Fin du formulaire -->
	<div class="modal-footer">
		<input class="btn btn-success" type="submit"	value="Créer la conversation" />
	</div>
</form>
