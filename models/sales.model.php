<?php

require_once "connection.php";

class SalesModel{


	/* ===============================
		=		SHOW SALES		=
	=================================*/
	static public function mdlShowSales($table,$item,$value){

		if ($item != null){

			$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $item = :$item ORDER BY id ASC");

			$stmt -> bindParam(":".$item, $value, PDO::PARAM_STR); 

			$stmt -> execute();

			return $stmt -> fetch();

		}else {


			$stmt = Connection::connect()->prepare("SELECT * FROM $table ORDER BY id ASC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();
		$stmt = null;

	}

	static public function mdlAddSales($table,$data){

			$stmt = Connection::connect()->prepare("INSERT INTO $table (code, customer_id, seller_id, products, tax, net_price, total, payment_method) VALUES (:code, :customer_id, :seller_id, :products, :tax, :net_price, :total, :payment_method)");
			$stmt -> bindParam(":code", $data["sales_code"], PDO::PARAM_INT);
			$stmt -> bindParam(":customer_id", $data["client_id"], PDO::PARAM_INT);
			$stmt -> bindParam(":seller_id", $data["cashier_id"], PDO::PARAM_INT);
			$stmt -> bindParam(":products", $data["products"], PDO::PARAM_STR);
			$stmt -> bindParam(":tax", $data["tax"], PDO::PARAM_STR);
			$stmt -> bindParam(":net_price", $data["net_price"], PDO::PARAM_STR);
			$stmt -> bindParam(":total", $data["total"], PDO::PARAM_STR);
			$stmt -> bindParam(":payment_method", $data["payment_method"], PDO::PARAM_STR);

			//$stmt ->execute();
			var_dump($stmt->errorInfo());

			if ($stmt->execute()) {
			
			   return 'success';
			
			} else {

			    return 'error';
			 }	

	}

	// date ranges 
	static public function mdlShowDateRanges($table, $initialdate, $finaldate){

		if ($initialdate == null){

			// bring all the sales without date filter 
			$stmt = Connection::connect()->prepare("SELECT * FROM $table ORDER BY id ASC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else if ($initialdate == $finaldate){

			// $finaldate = 2020-08-01; 
			// select all sales that have '2020-08-01' in any position in the date column 
			$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE sale_date LIKE '%$finaldate%'");

			$stmt -> bindParam(":sale_date", $finaldate, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else {

			// select sales between initial and final date
			$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE sale_date BETWEEN '$initialdate' AND '$finaldate'");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
	}

	static public function mdlShowTotalSales($table){

		$stmt = Connection::connect()->prepare("SELECT SUM(total) as total FROM $table");

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		$stmt = null;

	}
}