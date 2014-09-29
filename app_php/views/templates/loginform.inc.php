<form class="navbar-form pull-right" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?action=Login" >
  <a class="btn btn-danger" href="<?php echo $_SERVER['PHP_SELF'].'?action=SignUpForm';?>">Inscription</a>
	<input class="span2" placeholder="Pseudo" name="nickname" type="text" />
	<input class="span2" placeholder="Mot de passe" name="password"	type="password" />
	<input class="btn" name="connexionConnexion" type="submit" value="Connexion" />
</form>
