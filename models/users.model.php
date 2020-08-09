<?php

require_once "connection.php";

class UsersModel{

	/*=============================================
	SHOW USER 
	=============================================*/

	static public function MdlShowUsers($tableUsers, $item, $value){

		$stmt = Connection::connect()->prepare("SELECT * FROM $tableUsers WHERE $item = :$item");

		$stmt -> bindParam(":".$item, $value, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	static public function MdlShowAllUsers($usertable){

		$stmt = Connection::connect()->prepare("SELECT * FROM $usertable");
		$stmt -> execute();
		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = null;
	}


	/*=============================================
	ADD USER 
	=============================================*/	

	static public function mdlAddUser($table, $data){

		$stmt = Connection::connect()->prepare("INSERT INTO $table(name, user, password, profile, photo) VALUES (:name, :user, :password, :profile, :photo)");

		$stmt -> bindParam(":name", $data["name"], PDO::PARAM_STR);
		$stmt -> bindParam(":user", $data["user"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $data["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":profile", $data["profile"], PDO::PARAM_STR);
		$stmt -> bindParam(":photo", $data["photo"], PDO::PARAM_STR);

		if ($stmt->execute()) {
			
			return 'ok';
		
		} else {
			
			return 'error';
		}
		
		$stmt -> close();

		$stmt = null;
	}


	/*=============================================
	EDIT USER 
	=============================================*/

	static public function mdlEditUser($table, $data){

		$stmt = Connection::connect()->prepare("UPDATE $table set name = :name, password = :password, profile = :profile, photo = :photo WHERE user = :user");

		$stmt -> bindParam(":name", $data["name"], PDO::PARAM_STR);
		$stmt -> bindParam(":user", $data["user"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $data["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":profile", $data["profile"], PDO::PARAM_STR);
		$stmt -> bindParam(":photo", $data["photo"], PDO::PARAM_STR);

		if ($stmt->execute()) {
			
			return 'ok';
		
		} else {
			
			return 'error';
		
		}
		
		$stmt -> close();

		$stmt = null;
	}


	/*=============================================
	UPDATE LAST LOGIN
	=============================================*/
	
	static public function mdlUpdateLastLogin($table, $lastlogin, $currentdate, $id, $requestid){

	 $stmt=Connection::connect()->prepare("UPDATE $table set $lastlogin = :$lastlogin WHERE $id = :$id");

	 $stmt -> bindParam(":".$lastlogin, $currentdate, PDO::PARAM_STR);
	 $stmt -> bindParam(":".$id, $requestid, PDO::PARAM_STR);
	 if ($stmt->execute()) {
			return 'ok';
		
		} else {
			return 'error';
		
		}
		
		$stmt -> close();
		$stmt = null;
	}

	/*=============================================
	DELETE USER 
	=============================================*/	

	static public function mdlDeleteUser($table, $data){

		$stmt = Connection::connect()->prepare("DELETE FROM $table WHERE id = :id");

		$stmt -> bindParam(":id", $data, PDO::PARAM_STR);

		if ($stmt->execute()) {
			
			return 'ok';
		
		} else {

			return 'error';
		
		}
		
		$stmt -> close();

		$stmt = null;
	}

}