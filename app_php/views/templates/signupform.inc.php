<form method="post" action="index.php?action=SignUp" class="modal">
	<div class="modal-header">
		<h3>Inscription</h3>
	</div>
	<div class="form-horizontal modal-body">
<?php	if ($this->message!=="")
			echo '<div class="alert "'.$this->style.'">'.$this->message.'</div>';
?>
		<div class="control-group">
			<label class="control-label" for="username">Pseudo</label>
			<div class="controls">
				<input type="text" name="username" placeholder="Pseudo">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="passwd">Mot de passe</label>
			<div class="controls">
				<input type="password" name="passwd" placeholder="Mot de passe">
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="confirmation">Confirmation</label>
			<div class="controls">
				<input type="password" name="confirmation" placeholder="Confirmation">
			</div>
		</div>
		
		<!-- -->
		<div class="control-group">
			<label class="control-label" for="name">Nom</label>
			<div class="controls">
				<input type="text" name="name" placeholder="Nom">
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="firstname">Prénom</label>
			<div class="controls">
				<input type="text" name="firstname" placeholder="Prénom">
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="mailaddress">e-mail</label>
			<div class="controls">
				<input type="text" name="mailaddress" placeholder="e-mail">
			</div>
		</div>
		
		
	<!-- -->
	</div>
	<div class="modal-footer">
		<input class="btn btn-danger" type="submit" value="Créer mon compte" />
	</div>
</form>



<!--
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
-->
