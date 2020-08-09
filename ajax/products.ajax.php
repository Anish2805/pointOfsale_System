<?php

require_once "../controllers/products.controller.php";
require_once "../models/products.model.php";

require_once "../controllers/productcategories.controller.php";
require_once "../models/productcategories.model.php";

class AjaxProducts{

	// SHOW PRODUCTS ON TEXTBOXES 
	public $idProduct;
	public $bringproducts;

	public function AjaxEditProducts(){

		// condition to bring all the products to display since item & value is null
		if ($this ->bringproducts == "ok"){

			$item = null;
			$value = null;
			$order = "id"; 

			$request = controllerProducts::ctrShowProducts($item, $value, $order); // show details products where id= idProduct 

			echo json_encode($request);

		}else{

			$item = "id";
			$value = $this ->idProduct; 
			$order = "id";

			$request = controllerProducts::ctrShowProducts($item, $value, $order); // show details products where id= idProduct 

			echo json_encode($request);

		}

	}
}


// if the variable of product id is set upon clicking 
if (isset($_POST["idProduct"])){

	$editproduct = new AjaxProducts();
	$editproduct -> idProduct = $_POST["idProduct"];
	$editproduct -> AjaxEditProducts();  // execute the method of AjaxEditProduct 
}

/*====================================
= 		BRING ALL THE PRODUCTS 		 =
=====================================*/
if (isset($_POST["bringproducts"])){

	$bringproducts = new AjaxProducts();
	$bringproducts -> bringproducts = $_POST["bringproducts"];
	$bringproducts -> AjaxEditProducts();  // execute the method of AjaxEditProduct 
}

