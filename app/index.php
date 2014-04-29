<?php
include_once(dirname(__FILE__) . "/header.inc.php");

$toast = User::createUser("toast", "toast", "toast", "toast", "toast");

echo $toast->toJSON();
?>

<p>Toast</p>

<?php
include_once(dirname(__FILE__ . "/footer.inc.php"));
?>