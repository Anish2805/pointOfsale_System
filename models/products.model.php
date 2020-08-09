<?php 

require_once "connection.php";

class ProductModel {

	// SHOW PRODUCTS 
	static public function mdlShowProducts($table, $item, $value, $order){

		if ($item !=null){

			$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item ORDER BY id DESC");

			$stmt -> bindParam(":".$item, $value, PDO::PARAM_STR); 
 
			$stmt -> execute();

			return $stmt -> fetch(); 

		}else {

			$stmt = Connection::connect()->prepare("SELECT * FROM $table ORDER BY $order DESC");

			$stmt -> execute();

			return $stmt -> fetchAll(); 

		}

		$stmt -> close();

		$stmt = null;

	}

	// ADD PRODUCTS 
	static public function mdlAddProduct($table, $data){

		$stmt = Connection::connect()->prepare("INSERT INTO $table(idCategory, code, description, image, stock, buyingPrice, sellingPrice) VALUES (:idCategory, :code, :description, :image, :stock, :buyingPrice, :sellingPrice)");

		$stmt->bindParam(":idCategory", $data["idCategory"], PDO::PARAM_INT);
		$stmt->bindParam(":code", $data["code"], PDO::PARAM_STR);
		$stmt->bindParam(":description", $data["description"], PDO::PARAM_STR);
		$stmt->bindParam(":image", $data["image"], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $data["stock"], PDO::PARAM_STR);
		$stmt->bindParam(":buyingPrice", $data["buyingPrice"], PDO::PARAM_STR);
		$stmt->bindParam(":sellingPrice", $data["sellingPrice"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	// EDITING PRODUCTS 
	static public function mdlEditProduct($table, $data){

		$stmt = Connection::connect()->prepare("UPDATE $table SET idCategory=:idCategory, description=:description, image=:image, stock=:stock, buyingPrice=:buyingPrice, sellingPrice=:sellingPrice WHERE code=:code");

		$stmt->bindParam(":idCategory", $data["idCategory"], PDO::PARAM_INT);
		$stmt->bindParam(":code", $data["code"], PDO::PARAM_STR);
		$stmt->bindParam(":description", $data["description"], PDO::PARAM_STR);
		$stmt->bindParam(":image", $data["image"], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $data["stock"], PDO::PARAM_STR);
		$stmt->bindParam(":buyingPrice", $data["buyingPrice"], PDO::PARAM_STR);
		$stmt->bindParam(":sellingPrice", $data["sellingPrice"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "success";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlDeleteProducts($table, $data){

		$stmt = Connection::connect()->prepare("DELETE FROM $table WHERE id = :id");

		$stmt->bindParam(":id", $data, PDO::PARAM_INT);

		if($stmt->execute()){

			return "success";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	UPDATE PRODUCT STOCK AND QUANTITY SOLD
	=============================================*/

	static public function mdlUpdateProduct($table, $item1, $value1, $value){

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

	static public function mdlShowTotalQtyProductSold($table){

		$stmt = Connection::connect()->prepare("SELECT SUM(quantity_sold) AS total FROM $table");

		$stmt->execute();

		return $stmt -> fetch(); 


	}

}