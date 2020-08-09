<?php

require_once "../controllers/customers.controller.php";
require_once "../models/customers.model.php";

class AjaxClients{

	//EDIT CATEGORIES
	public $idClient;

	public function ajaxEditClients(){

		$idClient= "id";
		
		$clientIDOnBtnClick = $this->idClient;

	  	$request = ClientController::ctrShowClients($idClient, $clientIDOnBtnClick );

	   	echo json_encode($request);

	}

}

// create an object that is going to receive the data from db 
if (isset($_POST["idClient"])){

	$client = new AjaxClients();
	$client -> idClient = $_POST["idClient"]; // take the id of client when the btn is clicked and put it on client ID variable 
	// Then we execute the method ajax client 
	$client -> ajaxEditClients();

}