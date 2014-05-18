<?php

class Inputs{
	
	public static function getUIDFromPOST(){
		return $_POST['uid'];
	}
	
	public static function getSessTokenFromPOST(){
		return $_POST['sesstoken'];
	}
	
}

?>