<?php

require_once "../controllers/users.controller.php";
require_once "../models/users.model.php";

class AjaxUsers{

	/*=============================================
	EDIT USER
	=============================================*/

	public $idUser;

	public function ajaxEditUser(){

		$item = "id";
		$value = $this->idUser;

		$answer = ControllerUsers::ctrShowUsers($item, $value);

		echo json_encode($answer);
	}


	/*=============================================
	VALIDATE IF USER ALREADY EXISTS
	=============================================*/

	public $validateUser;

	public function ajaxValidateUser(){

		$item = "user";
		$value = $this->validateUser;

		$answer = ControllerUsers::ctrShowUsers($item, $value);

		echo json_encode($answer);

	}

}


/*=============================================
EDIT USER
=============================================*/

if (isset($_POST["idUser"])) {

	$edit = new AjaxUsers();
	$edit -> idUser = $_POST["idUser"];
	$edit -> ajaxEditUser();
}



/*=============================================
VALIDATE IF USER ALREADY EXISTS
=============================================*/


if (isset($_POST["validateUser"])) {

	$valUser = new AjaxUsers();
	$valUser -> validateUser = $_POST["validateUser"];
	$valUser -> ajaxValidateUser();
}
