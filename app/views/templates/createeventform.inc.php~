<? 

function generateList($value) { 
	?>
	<option value="<? echo $value; ?>"><? echo $value; ?></option>
<?
}

function generateDate($beginsOrEnds) {
	$day = $beginsOrEnds."_day";
	$month = $beginsOrEnds."_month";
	$year = $beginsOrEnds."_year";
	
	if($beginsOrEnds === "begins") echo("<p> Date de début : </p>");
	else if ($beginsOrEnds === "ends") echo("<p> Date de fin : </p>");
	else echo("supprime les 3 =");
	
	?>
	<!-- génère le code pour le jour -->
		<label id="label_sub" for="<? echo $day; ?>"> Jour<select>
		<option value="1" selected>1</option>
		<? 
			for ($i = 1; $i <= 31; $i++)
				generateList($i); 
		?>
		</select></label>
		
		
		<!-- génère le code pour le mois -->
		<label id="label_sub" for="<? echo $month; ?>">Mois<select>
		<option value="1" selected>1</option>
		<? 
			for ($i = 1; $i <= 12; $i++)
				generateList($i); 
		?>
		</select></label>
		
		
		<!-- génère le code pour l'année -->
		<label id="label_sub" for="<? echo $day; ?>">Année<select>
		<option value="2014" selected>2014</option>
		<? 
			for ($i = 2014; $i <= 2020; $i++)
				generateList($i); 
		?>
		</select></label><br>
<?
}

function generateEventTypes() {
	?>
	<label id="label_sub" for=event_type">Type d'événement<select>
	<option value="fête" selected>fête</option>
	<option value="rassemblement">rassemblement</option>
	<option value="rendez-vous">rencontre</option>
	<option value="rendez-vous">rendez-vous</option>
	</select></label><br>
<?	
}

function generateInput($name, $placeHolder) {
	?>
	<div class="control-group">
		<label class="control-label" for="questionSurvey"><? echo $name; ?></label>
		<div class="controls">
			<input class="span3" type="text" name="<? echo $name; ?>" placeholder="<? echo $placeHolder; ?>">
		</div>
	</div>
<?	
}
?>

<form method="post" action="index.php?action=AddSurvey" class="modal">
	<div class="modal-header">
		<h3 style="text-align:center">Création d'un événement</h3>
	</div>
	<div class="form-horizontal modal-body">
		<?	if ($this->message!=="")
			echo '<div class="alert '.$this->style.'">'.$this->message.'</div>';
		?>
		<div class="control-group">
			<label class="control-label" for="questionSurvey">Titre</label>
			<div class="controls">
				<input class="span3" type="text" name="questionSurvey" placeholder="Titre de l'événement">
			</div>
		</div>
		<br>
		
		<?
			generateDate("begins");
			generateDate("ends");
		?>
		
		<div class="control-group">
			<label class="control-label" for="questionSurvey">Lieu</label>
			<div class="controls">
				<input class="span3" type="text" name="questionSurvey" placeholder="Lieu où se déroule l'événement">
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="questionSurvey">Établissement</label>
			<div class="controls">
				<input class="span3" type="text" name="questionSurvey" placeholder="Si le lieu est un établissement">
			</div>
		</div>
		
		<? generateEventTypes(); ?>

		<div class="control-group">
			<label class="control-label" for="questionSurvey">Adresse</label>
			<div class="controls">
				<input class="span3" type="text" name="questionSurvey" placeholder="Adresse">
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="questionSurvey">Suite de l'adresse</label>
			<div class="controls">
				<input class="span3" type="text" name="questionSurvey" placeholder="Si l'adresse est trop longue...">
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="questionSurvey">Ville</label>
			<div class="controls">
				<input class="span3" type="text" name="questionSurvey" placeholder="Ville">
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="questionSurvey">Code postal</label>
			<div class="controls">
				<input class="span3" type="text" name="questionSurvey" placeholder="Code spostal">
			</div>
		</div>

		<?/*
		generateInput("Lieu", "Lieu où se déroule l'événement");
		generateInput("establishment", "Si le lieu est un établissement")
		generateInput("address0", "Adresse");
		generateInput("address2", "Si l'adresse est trop longue...");
		generateInput("city", "Ville");
		generateInput("postcode", "Code postal");*/
		?>
		
		
	</div> <!-- Fin du formulaire -->
	<div class="modal-footer">
		<input class="btn btn-success" type="submit"	value="Créer l'événement" />
	</div>
</form>



