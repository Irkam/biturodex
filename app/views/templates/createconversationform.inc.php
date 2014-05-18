<?php function generateUser() { ?>
	<label id="label_sub" for=establishmentIdType">Type d établissement<select>
	<option value="bar" selected>Bar</option>
	<option value="cinema">Cin�ma</option>
	<option value="nightclub">Bo�te de nuit</option>
	<option value="outside">Lieu en ext�rieur</option>
	</select></label><br> <?php
} 

// input pour le titre/nom, l'input la plus importante !
// il faut normalement s'assurer que $for $label et $name ne soient pas vides (ce n'est pas g�nant pour $placeHolder)
function generateFirst($for, $label, $name, $placeHolder) { ?>
	<div class="control-group">
			<label class="control-label" for="<?php echo($for); ?>"><?php echo($label); ?></label>
			<div class="controls">
				<input class="span3" type="text" name="<?php echo($name); ?>" placeholder="<?php echo($placeHolder); ?>">
			</div>
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
		generateFirst("establishmentName", "Nom de l'établissement", "establishmentName", "placeholder bidon");
		generateUser();
		 ?>
		<!-- latitude et longitude à gérer -->
		
		</div> <!-- Fin du formulaire -->
	<div class="modal-footer">
		<input class="btn btn-success" type="submit"	value="Créer la conversation" />
	</div>
</form>
