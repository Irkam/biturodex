<form class="navbar-form pull-right">
	<? if ($this->login!=null)  $this->displayCommands(); ?>	
	<a href="<? echo $_SERVER['PHP_SELF']; ?>?action=Logout" class="btn btn-danger" >Déconnexion</a>
	<span class="btn disabled"><? echo $this->login; ?></span> 
</form>


