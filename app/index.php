<?php
include_once(dirname(__FILE__) . "/header.inc.php");

$pussy = Establishment::createEstablishment("Pussy Twisters", 0, "2 Rue Crudère", null, "Marseille", "13007", null, null);
if(!is_null($pussy)){
	echo $pussy->toJSON();
	echo $pussy->addEstablishment();
}
?>

<p>Toast</p>

<?php
include_once(dirname(__FILE__ . "/footer.inc.php"));
?>