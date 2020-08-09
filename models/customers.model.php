<?php

require_once "connection.php";

class ClientModel{

	// ADD CLIENT
	static public function mdlAddClient($table,$data){

		$stmt = Connection::connect()->prepare("INSERT INTO $table (name, passportID, email, phone, address, birth_date) VALUES (:name, :passportID, :email, :phone, :address, :birth_date)");

		$stmt -> bindParam(":name", $data["clientname"], PDO::PARAM_STR);
		$stmt -> bindParam(":passportID", $data["passportid"], PDO::PARAM_INT);
		$stmt -> bindParam(":email", $data["email"], PDO::PARAM_STR);
		$stmt -> bindParam(":phone", $data["contactnum"], PDO::PARAM_STR);
		$stmt -> bindParam(":address", $data["address"], PDO::PARAM_STR);
		$stmt -> bindParam(":birth_date", $data["dateofbirth"], PDO::PARAM_STR);

		if ($stmt->execute()) {
			
			return 'success';
		
		} else {
			
			return 'error';
		}
		
		$stmt -> close();

		$stmt = null;


	}

	// SHOW CLIENTS
	static public function mdlShowClients($table,$item,$value){

		if ($item !=null){ //if the item is not null, the request will come with a specific information depending upon the item

			$stmt = Connection::connect()->prepare("SELECT * FROM $table where $item =:$item");

			$stmt -> bindParam(":".$item, $value, PDO::PARAM_STR); // bind the item value with the value parameter

			$stmt->execute(); 

			return $stmt ->fetch();

		}else{
			// if item is null, i.e the item is empty it displays all the data of the db table on the table 
			$stmt = Connection::connect()->prepare("SELECT * FROM $table");

			$stmt->execute(); 

			return $stmt ->fetchAll();

		}
	}


	// EDIT CLIENTS
	static public function mdlEditClient($table,$data){

		$stmt = Connection::connect()->prepare("UPDATE $table SET name = :name, passportID = :passportID, email= :email, phone =:phone, address =:address, birth_date=:birth_date WHERE id =:id");

		$stmt -> bindParam(":id", $data["id"], PDO::PARAM_INT);
		$stmt -> bindParam(":name", $data["clientname"], PDO::PARAM_STR);
		$stmt -> bindParam(":passportID", $data["passportid"], PDO::PARAM_INT);
		$stmt -> bindParam(":email", $data["email"], PDO::PARAM_STR);
		$stmt -> bindParam(":phone", $data["contactnum"], PDO::PARAM_STR);
		$stmt -> bindParam(":address", $data["address"], PDO::PARAM_STR);
		$stmt -> bindParam(":birth_date", $data["dateofbirth"], PDO::PARAM_STR);

		if ($stmt->execute()) {
			
			return 'success';
		
		} else {
			
			return 'error';
		}
		
		$stmt -> close();

		$stmt = null;


	}

	static public function mdlDeleteClient($table,$data){

		$stmt = Connection::connect()->prepare("DELETE FROM $table WHERE id = :id");

		$stmt -> bindParam(":id", $data, PDO::PARAM_STR);

		if ($stmt->execute()) {
			
			return 'success';
		
		} else {

			return 'error';
		
		}
		
		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	UPDATE CLIENT PURCHASES QTY 
	=============================================*/

	static public function mdlUpdateCustomer($table, $item1, $value1, $value){

		$stmt = Connection::connect()->prepare("UPDATE $table set $item1= :$item1 where id = :id ");

		$stmt -> bindParam(":".$item1, $value1, PDO::PARAM_STR);
		$stmt -> bindParam(":id", $value, PDO::PARAM_STR);

		if ($stmt->execute()) {
			
			return 'ok';
		
		} else {
			
			return 'error';
		
		}
		
		$stmt -> close();

		$stmt = null;
	}

}