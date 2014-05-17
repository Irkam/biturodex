<?php function generateEstablishmentTypes() { ?>
	<label id="label_sub" for=establishmentIdType">Type d'�tablissement<select>
	<option value="bar" selected>Bar</option>
	<option value="cinema">Cin�ma</option>
	<option value="nightclub">Bo�te de nuit</option>
	<option value="outside">Lieu en ext�rieur</option>
	</select></label><br> <?
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
	</div> <?
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
	</div> <?
}

// input pour le titre/nom, l'input la plus importante !
// il faut normalement s'assurer que $for $label et $name ne soient pas vides (ce n'est pas g�nant pour $placeHolder)
function generateFirstInput($for, $label, $name, $placeHolder) { ?>
	<div class="control-group">
			<label class="control-label" for="<? echo($for); ?>"><? echo($label); ?></label>
			<div class="controls">
				<input class="span3" type="text" name="<? echo($name); ?>" placeholder="<? echo($placeHolder); ?>">
			</div>
		</div>
		<br> <?
}
?>

<form method="post" action="index.php?action=AddSurvey" class="modal">
	<div class="modal-header">
		<h3 style="text-align:center">Cr�ation d'un �tablissement</h3>
	</div>
	<div class="form-horizontal modal-body">
		<?	if ($this->message!=="")
			echo '<div class="alert '.$this->style.'">'.$this->message.'</div>';
		?>
		
		generateFirstInput("establishmentName", "Nom de l'�tablissement", "establishmentName", "");
		generateEstablishmentTypes();
		generateAddressInputs();
		generateCityAndPostcodeInputs();
		<!-- latitude et longitude � g�rer -->
</form>
