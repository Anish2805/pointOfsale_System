<?php 

require_once "../controllers/products.controller.php";
require_once "../models/products.model.php";

require_once "../controllers/productcategories.controller.php";
require_once "../models/productcategories.model.php";


class ProductsTable{

 	//SHOW PRODUCTS TABLE IN JSON DATA FORMAT AND IT IS THEN SENT TO PRODUCT.JS 
  	
	public function showProductsTable(){

		$item = null;
		$value = null;
		$order = "id";

		$products = controllerProducts::ctrShowProducts($item, $value, $order);

		if(count($products) == 0){

			$jsonData = '{"data":[]}';

			echo $jsonData;

			return;
		}

		$jsonData = '{
			"data":[';

				for($i=0; $i < count($products); $i++){
					
					$image = "<img src='".$products[$i]["image"]."' width='40px'>";
					
					$item = "id";
				  	$value = $products[$i]["idCategory"];

				  	$categories = ControllerProductCategory::ShowProdCategoriesByIDCtr($item, $value);

					/*=============================================
					Stock
					=============================================*/
				  	
				  	if($products[$i]["stock"] <= 10){

		  				$stock = "<button class='btn btn-danger'>".$products[$i]["stock"]."</button>";

		  			}else if($products[$i]["stock"] > 11 && $products[$i]["stock"] <= 15){

		  				$stock = "<button class='btn btn-warning'>".$products[$i]["stock"]."</button>";

		  			}else{

		  				$stock = "<button class='btn btn-success'>".$products[$i]["stock"]."</button>";

		  			}

		  			/*=============================================
		 	 		ACTION BUTTONS
		  			=============================================*/ 

		  			$buttons =  "<div class='btn-group'><button class='btn btn-warning btnEditProduct' idProduct='".$products[$i]["id"]."' data-toggle='modal' data-target='#modalEditProduct'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnDeleteProduct' idProduct='".$products[$i]["id"]."' code='".$products[$i]["code"]."' image='".$products[$i]["image"]."'><i class='fa fa-times'></i></button></div>";


		  			// ALL PRODUCTS DATA IN Json Format presented on a Table
					$jsonData .='[
						"'.($i+1).'",
						"'.$image.'",
						"'.$products[$i]["code"].'",
						"'.$products[$i]["description"].'",
						"'.$categories["category"].'",
						"'.$stock.'",
						"$ '.$products[$i]["buyingPrice"].'",
						"$ '.$products[$i]["sellingPrice"].'",
						"'.$products[$i]["date_creation"].'",
						"'.$buttons.'"
					],';
				}

				$jsonData = substr($jsonData, 0, -1);
				$jsonData .= '] 

			}';

		echo $jsonData;
	}
}

// ACTIVATE PRODUCT TABLE 
$activateProductTable = new ProductsTable();
$activateProductTable -> showProductsTable(); 
