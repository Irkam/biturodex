<?php function generateEventTypes() {
	$types = Event::getTypes();
	?>
	<div class="control-group">
		<label id="label_sub" for="eventIdType">Type d'événement</label>
		<div class="controls">
			<select name="eventIdType">	
	<?php
	foreach($types as $type){
		?>
			<option value="<?php echo($type['id_type_event']);?>"><?php echo($type['label_type']);?></option>
		<?php
	}
	?>
	
			</select>
		</div>
	</div>
	<?php
} 

function generateAddressInputs() { ?>
	<div class="control-group">
			<label class="control-label" for="address0">Adresse</label>
			<div class="controls">
				<input class="span3" type="text" name="address0" placeholder="Adresse" id="address0" onblur="updateFormLatLng()">
			</div>
		</div>
		
	<div class="control-group">
		<label class="control-label" for="address2">Suite de l'adresse</label>
		<div class="controls">
			<input class="span3" type="text" name="address2" placeholder="Si l'adresse est trop longue..." id="address1" onblur="updateFormLatLng()">
		</div>
	</div> <?php
}

function generateCityAndPostcodeInputs() { ?>
	<div class="control-group">
			<label class="control-label" for="city">Ville</label>
			<div class="controls">
				<input class="span3" type="text" name="city" placeholder="Ville" id="city" onblur="updateFormLatLng()">
			</div>
		</div>
		
	<div class="control-group">
		<label class="control-label" for="postcode">Code postal</label>
		<div class="controls">
			<input class="span3" type="text" name="postcode" placeholder="Code postal" id="postcode" onblur="updateFormLatLng()">
		</div>
	</div> <?php
}

// input pour le titre/nom, l'input la plus importante !
// il faut normalement s'assurer que $for $label et $name ne soient pas vides (ce n'est pas gênant pour $placeHolder)
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

<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDU_a-nbiISFCPhqF-YluAD6f4e2CMafwE&sensor=TRUE">
    </script>
<script type='text/javascript' src='jquery-2.1.0.js'></script>
<script type='text/javascript' src='script_js/js.js'></script>
<form method="post" action="index.php?action=CreateEvent" class="modal">
	<input type="hidden" name="coordlat" id="coordlat" value="0" />
	<input type="hidden" name="coordlng" id="coordlng" value="0" />
	<div class="modal-header">
		<h3 style="text-align:center">Création d'un événement</h3>
	</div>
	<div class="form-horizontal modal-body">
		<?php	if ($this->message!=="")
			echo '<div class="alert '.$this->style.'">'.$this->message.'</div>';
		?>
		
		<?php
		generateFirstInput("establishmentName", "Nom de l'établissement", "establishmentName", "Nom");
		generateEventTypes();
		generateAddressInputs();
		generateCityAndPostcodeInputs();
		?>
		
		<!-- latitude et longitude à gérer -->
		</div> <!-- Fin du formulaire -->
		<div class="modal-footer">
		<input class="btn btn-success" type="submit"	value="Créer l'événement" />
	</div>
</form>