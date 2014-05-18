<?php function generateEstablishmentTypes() { ?>
	<label id="label_sub" for=establishmentIdType">Type d établissement<select>
	<option value="bar" selected>Bar</option>
	<option value="cinema">Cin�ma</option>
	<option value="nightclub">Bo�te de nuit</option>
	<option value="outside">Lieu en ext�rieur</option>
	</select></label><br> <?php
} 

function generateAddressInputs() { ?>
	<div class="control-group">
			<label class="control-label" for="address0">Adresse</label>
			<div class="controls">
				<input class="span3" type="text" name="address0" placeholder="Adresse">
			</div>
		</div>
		
	<div class="control-group">
		<label class="control-label" for="address2">Suite de l'adresse</label>
		<div class="controls">
			<input class="span3" type="text" name="address2" placeholder="Si l'adresse est trop longue...">
		</div>
	</div> <?php
}

function generateCityAndPostcodeInputs() { ?>
	<div class="control-group">
			<label class="control-label" for="city">Ville</label>
			<div class="controls">
				<input class="span3" type="text" name="city" placeholder="Ville">
			</div>
		</div>
		
	<div class="control-group">
		<label class="control-label" for="postcode">Code postal</label>
		<div class="controls">
			<input class="span3" type="text" name="postcode" placeholder="Code spostal">
		</div>
	</div> <?php
}

// input pour le titre/nom, l'input la plus importante !
// il faut normalement s'assurer que $for $label et $name ne soient pas vides (ce n'est pas g�nant pour $placeHolder)
function generateFirstInput($for, $label, $name, $placeHolder) { ?>
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
		<h3 style="text-align:center">Création d'un établissement</h3>
	</div>
	<div class="form-horizontal modal-body">
		<?php	if ($this->message!=="")
			echo '<div class="alert '.$this->style.'">'.$this->message.'</div>';
		?>
		
		<?php
		generateFirstInput("establishmentName", "Nom de l'établissement", "establishmentName", "placeholder bidon");
		generateEstablishmentTypes();
		generateAddressInputs();
		generateCityAndPostcodeInputs();
		?>
		
		<!-- latitude et longitude à gérer -->
		</div> <!-- Fin du formulaire -->
		<div class="modal-footer">
		<input class="btn btn-success" type="submit"	value="Créer l'établissement" />
	</div>
</form>
