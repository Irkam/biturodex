<form method="post" action="index.php?action=UpdateUser" class="modal">
	<div class="modal-header">
		<h3>Modification du mot de passe</h3>
	</div>
	<div class="form-horizontal modal-body">
<?	if ($this->message!=="")
			echo '<div class="alert "'.$this->style.'">'.$this->message.'</div>';
?>
		<div class="control-group">
			<label class="control-label" for="signUpLogin">Pseudo</label>
			<div class="controls">
				<input  disabled type="text" name="signUpLogin" placeholder="Pseudo" value="<? echo $this->login; ?>">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="updatePassword">Mot de passe</label>
			<div class="controls">
				<input type="password" name="updatePassword" placeholder="Mot de passe">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="updatePassword2">Confirmation</label>
			<div class="controls">
				<input type="password" name="updatePassword2" placeholder="Confirmation">
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<input class="btn btn-danger" type="submit" value="Changer de mot de passe" />
	</div>
</form>
