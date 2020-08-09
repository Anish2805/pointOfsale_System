<?php

class SalesController{

	static public function ctrShowSales($item,$value){

		$table="sales";

		$request = SalesModel::mdlShowSales($table,$item,$value); 

		return $request; 

	}

	static public function ctrCreateSale(){

		if (isset($_POST["NewSaleNumber"])){ // if this variable is set 

			/*==============================================================================================*
			UPDATE THE PURCHASES OF THE CLIENT AND REDUCE THE STOCK AND INCREASE THE SALES purchased   OF THE PRODUCTS 
			=================================================================================================*/

			// All the product comes from the listproducts and stored in a variable $productlist 
			$productlist = json_decode($_POST["listproducts"], true) ;

			//var_dump($productlist); // show product contents available in sales array 
			//echo "------";

			$totalProductPurchasedArray = array();

			foreach ($productlist as $key => $value){

				array_push($totalProductPurchasedArray , $value["productquantity"]); // push the product quantity in an array of total number of product purchased

				$product_table = "products"; 

				$prod_id = "id"; 

				$prod_id_inprodlist = $value["id"]; // produt id in product list

				$order = "id";

				// select the product first then update the quantity sold and stock 
				$fetchproduct = ProductModel::mdlShowProducts($product_table, $prod_id, $prod_id_inprodlist, $order);

				var_dump($fetchproduct["quantity_sold"]); // show value of quantity product sold in Product Table 

				$quantity_sold_inprodTable = "quantity_sold";
				$new_value_of_qtySold = $value["productquantity"] + $fetchproduct["quantity_sold"];
				$newSales = ProductModel::mdlUpdateProduct($product_table, $quantity_sold_inprodTable, $new_value_of_qtySold, $prod_id_inprodlist);


				$initial_stock_inprodTable = "stock";
				$newstock_from_prodlist = $value["stock"];
				$newStock = ProductModel::mdlUpdateProduct($product_table, $initial_stock_inprodTable, $newstock_from_prodlist, $prod_id_inprodlist);
			
			}


			// update the total number of purchases for each customer who has buy 
			$customer_table = "clients";

			$customer_id_inTable = "id"; 

			$customervalue = $_POST["SelectedCustomer"]; // customer name from textbox in sale section 

			$fetchcustomers = ClientModel::mdlShowClients($customer_table, $customer_id_inTable , $customervalue);

			var_dump($fetchcustomers["purchases"]); // fetch purchases of selected customer from Clients Table db 

			$customer_purchases_inTable = "purchases"; 

			$sumofpurchaseditems = array_sum($totalProductPurchasedArray) + $fetchcustomers["purchases"];

			$customerPurchases = ClientModel::mdlUpdateCustomer($customer_table, $customer_purchases_inTable ,$sumofpurchaseditems , $customervalue);

			// insert the customer's last purchase date by updating it 
			$column_name = "last_purchased"; 

			date_default_timezone_set('Asia/Kuala Lumpur');

			$datee = date('Y-m-d');

			$timee = date('H:i:s');

			$dateNtime = $datee.'-'.$timee;
			
			$customerPurchases = ClientModel::mdlUpdateCustomer($customer_table, $column_name ,$dateNtime , $customervalue);


			// save sale transaction
			$sale_table = "sales";

			 $data = array( "cashier_id" => $_POST["idSeller"], 
							"client_id" => $_POST["SelectedCustomer"],
							"sales_code"=> $_POST["NewSaleNumber"],
							"products"=> $_POST["listproducts"],
							"tax"=> $_POST["newTaxPrice"],
							"net_price"=> $_POST["newNetPrice"],
							"total"=> $_POST["totalSaleWithNoFormat"],
							"payment_method"=> $_POST["listPaymentMethod"]); 

			$request = SalesModel::mdlAddSales($sale_table,$data); 

			if ($request == "success"){

				echo '<script>
						
						swal({
							type: "success",
							title: "Sale Transaction has been added succesfully!",
							showConfirmButton: true,
							confirmButtonText: "Close"

						}).then(function(result){

							if(result.value){

								window.location = "create-sales";
							}

						});
						
						</script>';
			}
			else {

				echo '<script>
					
					swal({
						type: "error",
						title: "Error in Saving Sale Transaction",
						showConfirmButton: true,
						confirmButtonText: "Close"
			
						}).then(function(result){

							if(result.value){

								window.location = "create-sales";
							}

						});
					
				</script>';
			}

		}
	
	}

	// date ranges 
	static public function ctrShowDateRanges($initialdate, $finaldate){

		$table = "sales";

		$request = SalesModel:: mdlShowDateRanges($table, $initialdate, $finaldate);

		return $request;
	}

	// show total sales 
	static public function ctrShowTotalSales(){

		$table = "sales";
		$request = SalesModel::mdlShowTotalSales($table);
		return $request;

	}

	// delete Sales Trans 
	// static public function ctrDeleteSaleTransaction(){

	// 	if (isset($_GET["SaleID"])){

	// 		$table = "sales";

	// 		$item = "id";
	// 		$value = $_GET["SaleID"];  // get sale ID from the URL 

	// 		$showSelectedSaleTransaction = SalesModel::mdlShowSales($table,$item,$value); 
			
	// 		//bring all the sales
	// 		$itemSales = null;
	// 		$valueSales = null;

	// 		$showSaleTransactions = SalesModel::mdlShowSales($table,$itemSales,$valueSales); 

	// 		$TransDate = array();

	// 		foreach ($showSaleTransactions as $key => $value) {

	// 			// var_dump($showSelectedSaleTransaction);
	// 			// make a match for sales having the same customer id 
	// 			if ($value["customer_id"] == $showSelectedSaleTransaction["customer_id"]){

	// 				// then push the customer's sales date in the array
	// 				array_push($TransDate, $value["sale_date"]);

	// 			}
	// 		}

	// 		var_dump($TransDate); // show the saved date in the array
	// 		var_dump(count($TransDate)); // count elements in an array 

	// 		$table = "clients";

	// 		// if there are more than 2 sales transac dates
	// 		if(count($TransDate) > 1){

	// 			if($showSelectedSaleTransaction["sale_date"] > $TransDate[count($TransDate)-2]){

	// 				$item = "last_purchased";
	// 				$NewPurchaseValue = $TransDate[count($TransDate)-2];
	// 				$valueIDCustomer = $showSelectedSaleTransaction["customer_id"];
	// 				$UpdateLastPurchaseDate = ClientModel::mdlUpdateCustomer($table, $item, $NewPurchaseValue, $valueIDCustomer);

	// 			}else {

	// 				$item = "last_purchased";
	// 				$NewPurchaseValue = $TransDate[count($TransDate)-1];
	// 				$valueIDCustomer = $showSelectedSaleTransaction["customer_id"];
	// 				$UpdateLastPurchaseDate = ClientModel::mdlUpdateCustomer($table, $item, $NewPurchaseValue, $valueIDCustomer);


	// 			}

	// 		}else{ // if there is only one transaction date to be deleted, update the last purchased date to 0

	// 			$item = "last_purchased";
	// 			$value = "0000-00-00 00:00:00";
	// 			$valueIDCustomer = $showSelectedSaleTransaction["customer_id"];
	// 			$UpdateLastPurchaseDate = ClientModel::mdlUpdateCustomer($table, $item, $value, $valueIDCustomer);
	// 		}


	// 	}
	// }

}

