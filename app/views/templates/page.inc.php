<!DOCTYPE html>
<html lang="en">
  <head>
		<meta charset="utf-8">
		<title>Biturodex</title>
		<link rel="stylesheet" type="text/css" href="bootstrap.min.css" />
</head>

<body>
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<?php $this->displaySearchForm(); ?>
				<?php 
					if ($this->login===null) $this->displayLoginForm();
					else $this->displayLogoutForm();
				?>
			</div>
		</div>
	</div>
	
<?php 
	$this->displayBody(); 
?>

</body>
</html>
