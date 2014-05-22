<?php function generateUser() { ?>
	
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

<form method="post" action="index.php?action=AddSurvey" class="modal" id="newconversationform">
	<input type="hidden" name="useraddcount" id="conversationuserscount" value=0 />
	<div class="modal-header">
		<h3 style="text-align:center">Création d'une Conversation</h3>
	</div>
	<div class="form-horizontal modal-body">
		<?php	if ($this->message!=="")
			echo '<div class="alert '.$this->style.'">'.$this->message.'</div>';
		?>
		
		<?php 
			generateFirst("conversationName");
		?>
		
		<script type='text/javascript' src='script_js/js.js'></script>
		<script type='text/javascript' src='jquery-2.1.0.js'></script>
		<input type="text" id="usersearchinput" />
		<input type="button" name="ajout" value="Ajout" onclick="ajoutUser()" />
		
		<ul id="useraddlist">
			
		</ul>
		
		</div> <!-- Fin du formulaire -->
	<div class="modal-footer">
		<input class="btn btn-success" type="submit"	value="Créer la conversation" />
	</div>
</form>
