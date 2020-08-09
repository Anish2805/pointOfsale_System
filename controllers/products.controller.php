<?php

class controllerProducts{

	// SHOW PRODUCTS 
	static public function ctrShowProducts($item,$value,$order){

		$table ="products";

		$request = ProductModel::mdlShowProducts($table,$item,$value,$order);

		return $request;
	}

/*=============================================
	// CREATE PRODUCTS // 
=============================================*/

static public function ctrCreateProducts(){

	if(isset($_POST["newDescription"])){

		if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newDescription"]) &&
		   preg_match('/^[0-9]+$/', $_POST["newStock"]) &&	
		   preg_match('/^[0-9.]+$/', $_POST["newBuyingPrice"]) &&
		   preg_match('/^[0-9.]+$/', $_POST["newSellingPrice"])){

	   		/*=============================================
			VALIDATE IMAGE
			=============================================*/

		   	$route = "views/img/products/default/anonymous.png";

		   	if(isset($_FILES["newProdPhoto"]["tmp_name"])){

				list($width, $height) = getimagesize($_FILES["newProdPhoto"]["tmp_name"]);

				$newWidth = 500;
				$newHeight = 500;

				/*=============================================
				create the folder to save the picture
				=============================================*/

				$folder = "views/img/products/".$_POST["newCode"];

				mkdir($folder, 0755);

				/*=============================================
				APPLY DEFAULT PHP FUNCTIONS ACCORDING TO THE IMAGE FORMAT
				=============================================*/

				if($_FILES["newProdPhoto"]["type"] == "image/jpeg"){

					/*=============================================
					SAVE THE IMAGE IN THE FOLDER
					=============================================*/

					$random = mt_rand(100,999);

					$route = "views/img/products/".$_POST["newCode"]."/".$random.".jpg";

					$origin = imagecreatefromjpeg($_FILES["newProdPhoto"]["tmp_name"]);						

					$destiny = imagecreatetruecolor($newWidth, $newHeight);

					imagecopyresized($destiny, $origin, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

					imagejpeg($destiny, $route);

				}

				if($_FILES["newProdPhoto"]["type"] == "image/png"){

					/*=============================================
					SAVE THE IMAGE IN THE FOLDER
					=============================================*/

					$random = mt_rand(100,999);

					$route = "views/img/products/".$_POST["newCode"]."/".$random.".png";

					$origin = imagecreatefrompng($_FILES["newProdPhoto"]["tmp_name"]);						

					$destiny = imagecreatetruecolor($newWidth, $newHeight);

					imagecopyresized($destiny, $origin, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

					imagepng($destiny, $route);

				}

			}

			$table = "products";

			$data = array("idCategory" => $_POST["newCategory"],
						   "code" => $_POST["newCode"],
						   "description" => $_POST["newDescription"],
						   "stock" => $_POST["newStock"],
						   "buyingPrice" => $_POST["newBuyingPrice"],
						   "sellingPrice" => $_POST["newSellingPrice"],
						   "image" => $route);

			$answer = ProductModel::mdlAddProduct($table, $data);

			if($answer == "ok"){

				echo'<script>

					swal({
						  type: "success",
						  title: "The product has been saved sucessfully",
						  showConfirmButton: true,
						  confirmButtonText: "Close"
						  }).then(function(result){
									if (result.value) {

									window.location = "products";

									}
								})

					</script>';

			}


		}else{

			echo'<script>

				swal({
					  type: "error",
					  title: "Error in Adding the Product! Operation Unsuccessful!",
					  showConfirmButton: true,
					  confirmButtonText: "Close"
					  }).then(function(result){
						if (result.value) {

						window.location = "products";

						}
					})

		  	</script>';
		}

	}

}

/*=============================================
// EDIT PRODUCT // 
=============================================*/
static public function ctrEditProduct(){

	if(isset($_POST["editDescription"])){

		if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editDescription"]) &&
		   preg_match('/^[0-9]+$/', $_POST["editStock"]) &&	
		   preg_match('/^[0-9.]+$/', $_POST["editBuyingPrice"]) &&
		   preg_match('/^[0-9.]+$/', $_POST["editSellingPrice"])){

	   		/*=============================================
			VALIDATE IMAGE
			=============================================*/

		   	$route = $_POST["ActualImage"];

		   	if(isset($_FILES["editProdPhoto"]["tmp_name"]) && !empty($_FILES["editProdPhoto"]["tmp_name"])){

				list($width, $height) = getimagesize($_FILES["editProdPhoto"]["tmp_name"]);

				$newWidth = 500;
				$newHeight = 500;

				/*=============================================
				Create the folder to save the picture
				=============================================*/

				$folder = "views/img/products/".$_POST["editCode"];

				if (!empty($_POST["ActualImage"]) && $_POST["ActualImage"] != "views/img/products/anonymous.png"){

					// delete the picture inside that folder 
					unlink($_POST["ActualImage"]);
				}else {
					mkdir($folder, 0755);

				}

				/*=============================++++++++++++++++================
				APPLY DEFAULT PHP FUNCTIONS ACCORDING TO THE IMAGE FORMAT
				=================================++++++++++++++++++============*/

				if($_FILES["editProdPhoto"]["type"] == "image/jpeg"){

					/*=============================================
					SAVE THE IMAGE IN THE FOLDER
					=============================================*/

					$random = mt_rand(100,999);

					$route = "views/img/products/".$_POST["editCode"]."/".$random.".jpg";

					$origin = imagecreatefromjpeg($_FILES["editProdPhoto"]["tmp_name"]);						

					$destiny = imagecreatetruecolor($newWidth, $newHeight);

					imagecopyresized($destiny, $origin, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

					imagejpeg($destiny, $route);

				}

				if($_FILES["editProdPhoto"]["type"] == "image/png"){

					/*=============================================
					SAVE THE IMAGE IN THE FOLDER
					=============================================*/

					$random = mt_rand(100,999);

					$route = "views/img/products/".$_POST["editCode"]."/".$random.".png";

					$origin = imagecreatefrompng($_FILES["editProdPhoto"]["tmp_name"]);						

					$destination = imagecreatetruecolor($newWidth, $newHeight);

					imagecopyresized($destination, $origin, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

					imagepng($destination, $route);

				}

			}

			$table = "products";

			$data = array("idCategory" => $_POST["editCategory"],
						   "code" => $_POST["editCode"],
						   "description" => $_POST["editDescription"],
						   "stock" => $_POST["editStock"],
						   "buyingPrice" => $_POST["editBuyingPrice"],
						   "sellingPrice" => $_POST["editSellingPrice"],
						   "image" => $route);

			$answer = ProductModel::mdlEditProduct($table, $data);

			if($answer == "success"){

				echo'<script>

					swal({
						  type: "success",
						  title: "The Product has been edited sucessfully",
						  showConfirmButton: true,
						  confirmButtonText: "Close"
						  }).then(function(result){
									if (result.value) {

									window.location = "products";

									}
								})

					</script>';

			}


		}else{

			echo'<script>

				swal({
					  type: "error",
					  title: "Error in editing the Product. Operation Unsuccessful!",
					  showConfirmButton: true,
					  confirmButtonText: "Close"
					  }).then(function(result){
						if (result.value) {

						window.location = "products";

						}
					})

		  	</script>';
		}

	}

}

/*=======================================
	DELETE PRODUCTS
========================================*/

static public function ctrDeleteProducts(){

	// the controller will get the variable of ID Product 
	if (isset($_GET['idProduct'])){
		$table = "products";
		$data = $_GET["idProduct"];

		if ($_GET["image"] != "" & $_GET["image"] != "views/img/products/anonymous.png"){

			// delete the image file 
			unlink($_GET["image"]);
			// and delete the folder with the gived product code name 
			rmdir('views/img/products/'.$_GET["code"]);
		}

		$request_to_mdl = ProductModel::mdlDeleteProducts($table,$data);

		if ($request_to_mdl == "success"){

			echo'<script>

					swal({
						  type: "success",
						  title: "The Product has been Deleted sucessfully",
						  showConfirmButton: true,
						  confirmButtonText: "Close"
						  }).then(function(result){
									if (result.value) {

									window.location = "products";

									}
								})

					</script>';

		}

	}

}

static public function ctrShowTotalProductQtySold (){

	$table = "products";
	$request = ProductModel::mdlShowTotalQtyProductSold($table);
	
	return $request;
	
}


}

