<?php
class ControllerProductCategory{

//ADD PRODUCT CATEGORY
	static public function ctrAddProductCategory(){

		if (isset($_POST["ProdCategoryName"])){ // if the product category field is set 

			if (preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["ProdCategoryName"])){
	  		//now we will send the information to the model which will insert it into the right table in the db 
			$table = "productcategories";
			$data = $_POST["ProdCategoryName"];

			$request = CategoryModel:: AddProdCategoryMdl($table,$data);
			if ($request =="success"){

				echo '<script>
						
						swal({
							type: "success",
							title: "Your Product Category has been added succesfully!",
							showConfirmButton: true,
							confirmButtonText: "Close"

						}).then(function(result){

							if(result.value){

								window.location = "product-categories";
							}

						});
						
						</script>';
			}else {

					echo '<script>
					
						swal({
							type: "error",
							title: "No special characters or blank fields",
							showConfirmButton: true,
							confirmButtonText: "Close"
			
							}).then(function(result){

								if(result.value){

									window.location = "product-categories";
								}

							});
					
							</script>';
					}
			}

		}
	}

	static public function ShowProdCategoriesCtr(){

		$table = "productcategories";
		$request = CategoryModel:: ShowProdCategoryMdl($table);

			return $request;
	}

	static public function ShowProdCategoriesByIDCtr($categoryID, $categoryIdOnBtnClick){

		$table = "productcategories";
		$request = CategoryModel:: ShowProdCategoryByIDMdl($table,$categoryID,$categoryIdOnBtnClick);

			return $request;
	}

	static public function EditProductCategoryCtr(){

		if (isset($_POST["EditedProdCategoryName"])){ // if the product category field is set 

			if (preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["EditedProdCategoryName"])){
	  		//now we will send the information to the model which will insert it into the right table in the db 
			$table = "productcategories";
			$data = array("editedprodCategory"=>$_POST["EditedProdCategoryName"],
						  "editedprodID"=>$_POST["Categoryid"]);

			$request = CategoryModel:: EditProdCategoryMdl($table,$data);

			if ($request == "success"){

				echo '<script>
						
						swal({
							type: "success",
							title: "The Product Category has been changed succesfully!",
							showConfirmButton: true,
							confirmButtonText: "Close"

						}).then(function(result){

							if(result.value){

								window.location = "product-categories";
							}

						});
						
						</script>';
			}else {

					echo '<script>
					
						swal({
							type: "error",
							title: "No special characters or blank fields",
							showConfirmButton: true,
							confirmButtonText: "Close"
			
							}).then(function(result){

								if(result.value){

									window.location = "product-categories";
								}

							});
					
							</script>';
					}
			}

		}

	}

	// method for deleting product category
	static public function ctrDeleteCategory(){

		if (isset($_GET["CategoryID"])){

			$table = "productcategories";
			$data = $_GET["CategoryID"]; 

			$request = CategoryModel::mdlDeleteCategory($table, $data);

			if ($request == "success"){

				echo '<script>
						
						swal({
							type: "success",
							title: "The Product Category has been deleted succesfully!",
							showConfirmButton: true,
							confirmButtonText: "Close"

						}).then(function(result){

							if(result.value){

								window.location = "product-categories";
							}

						});
						
					</script>';

			}
		}

	}
}

