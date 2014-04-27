<?php

class User{
	public $uid;
	public $username;
	public $email;
	public $name;
	public $firstname;
	protected $sessionToken;
	
	/**
	Renvoie un utilisateur en fonction de son UID. Ne peut être utilisé pour connecter un utilisateur
	(ne renvoie pas de token de session)
	*/
	public __init__($uid){
	}
	
	/**
	Renvoie un utilisateur connecté à l'aide des deux paramètres, et initialise son token de session.
	*/
	public __init__($username, $passwd){
	}

	/**
	Renvoie un utilisateur connecté à l'aide des deux paramètres, et initialise son token de session.
	*/
	public __init__($email, $passwd){
	}

	/**
	Créée un utilisateur s'il n'existe pas dans la base de données, sinon renvoie une erreur
	*/
	public function addUser(){
	
	}
	
	
	
	/**
	Récupère les statistiques concernant l'utilisateur
	*/
	public function getUserStats(){
	
	}
	
	/**
	Récupère les statistiques émises par l'utilisateur
	*/	
	public function getStatsByUser(){

	}
}

?>
