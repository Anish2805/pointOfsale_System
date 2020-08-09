<?php 

require_once "connection.php";

class CategoryModel{

	static public function AddProdCategoryMdl($table,$data){

		// prepare the sql statement
		$stmt = Connection::connect()->prepare("INSERT INTO $table (category) VALUES (:prodcategory)");

		$stmt -> bindParam(":prodcategory", $data, PDO::PARAM_STR);

		if ($stmt->execute()) {
			
			return 'success';
		
		} else {
			
			return 'error';
		}
		
		$stmt -> close();
		$stmt = null;
	}

	static public function ShowProdCategoryMdl($table){

		$stmt = Connection::connect()->prepare("SELECT *FROM $table");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		$stmt = null;
	}

	static public function ShowProdCategoryByIDMdl($table,$categoryID,$categoryIdOnBtnClick){

		$stmt = Connection::connect()->prepare("SELECT *FROM $table WHERE $categoryID = :$categoryID");

		$stmt -> bindParam(":".$categoryID, $categoryIdOnBtnClick, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = null;
	}

	//EDIT PRODUCT CATEGORY
	static public function EditProdCategoryMdl($table,$data){

		$stmt = Connection::connect()->prepare("UPDATE $table SET category=:category WHERE id =:id");

		$stmt -> bindParam(":category", $data["editedprodCategory"], PDO::PARAM_STR);
		$stmt -> bindParam(":id", $data["editedprodID"], PDO::PARAM_INT);
		

		if ($stmt->execute()) {
			
			return 'success';
		
		} else {
			
			return 'error';
		}
		
		$stmt -> close();
		$stmt = null;

	}

	//DELETE PRODUCT CATEGORY
	static public function mdlDeleteCategory($table,$data){

		$stmt = Connection::connect()->prepare("DELETE FROM $table WHERE id =:id");

		$stmt -> bindParam(":id", $data, PDO::PARAM_INT);
		

		if ($stmt->execute()) {
			
			return 'success';
		
		} else {
			
			return 'error';
		}
		
		$stmt -> close();
		$stmt = null;
	}
}