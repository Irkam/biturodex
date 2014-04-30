<?php
include_once(dirname(__FILE__) . "/header.inc.php");

$toast = User::getUserByUID(1);
$pwet = User::getUserByUID(2);

echo "Toast : " . $toast->toJSON() . "<br />";
echo "Pwet : " . $pwet->toJSON() . "<br />";

/*
$conv = Conversation::createConversation();
$conv->addConversation();

$conv->subscribeUsers(array($toast->getUID(), $pwet->getUID()));

$conv->addMessage(Message::createMessage($conv->getId(), $toast->getUID(), "Toast"));
$conv->addMessage(Message::createMessage($conv->getId(), $pwet->getUID(), "Pwet"));

echo json_encode($conv->getMessages());
*/
 
Event::createEvent("soiréé YOLO", 1, $toast->getUID(), null, null, null, $address=null, 6, time(), time()+3600)->addEvent(); 

?>

<?php
include_once(dirname(__FILE__ . "/footer.inc.php"));
?>