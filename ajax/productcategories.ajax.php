<?php

require_once "../controllers/productcategories.controller.php";
require_once "../models/productcategories.model.php";

class AjaxProductCategories{

	//EDIT CATEGORIES
	public $idCategory;

	public function ajaxEditProductCategories(){

		$categoryID = "id";
		$categoryIDOnBtnClick = $this->idCategory;

	  	$request = ControllerProductCategory::ShowProdCategoriesByIDCtr($categoryID, $categoryIDOnBtnClick);

	   	echo json_encode($request);

	}

}

// create an object that is going to receive the data from db 
if (isset($_POST["idCategory"])){

	$category = new AjaxProductCategories();
	$category -> idCategory = $_POST["idCategory"]; // take the id of product category when the btn is clicked and put it on Category ID variable 
	// Then we execute the method ajax category 
	$category -> ajaxEditProductCategories();

}