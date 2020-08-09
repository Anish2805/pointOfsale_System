<?php

class ClientController{

	static public function ctrCreateClient(){

		if (isset($_POST["newClientName"])){

            // allow special characters by using preg match
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newClientName"]) &&
			   preg_match('/^[0-9]+$/', $_POST["newPassID"])){

			   $table = "clients";

			   $data = array('clientname' => $_POST["newClientName"],
							 'passportid' => $_POST["newPassID"],
							 'email' => $_POST["newEmail"],
							 'contactnum' => $_POST["newContactNumber"],
							 'address' => $_POST["newAddress"],
							 'dateofbirth' => $_POST["newBirthDate"]);

			   $request_to_model = ClientModel:: mdlAddClient($table,$data);

			   if ($request_to_model == "success"){

			   	echo '<script>
						
						swal({
							type: "success",
							title: "The Client has been added succesfully!",
							showConfirmButton: true,
							confirmButtonText: "Close"

						}).then(function(result){

							if(result.value){

								window.location = "customers";
							}

						});
						
						</script>';

			   }


			}else {

				echo '<script>
					
					swal({
						type: "error",
						title: "No special characters or blank fields",
						showConfirmButton: true,
						confirmButtonText: "Close"
			
						}).then(function(result){

							if(result.value){

								window.location = "customers";
							}

						});
					
				</script>';

			}


		}
	}

	static public function ctrShowClients($item, $valor){

		$table = "clients";

		$request_to_model = ClientModel::mdlShowClients($table,$item,$valor);

		return $request_to_model;

	}

	static public function ctrEditClient(){

		if (isset($_POST["editClientName"])){

            // allow special characters by using preg match
			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editClientName"]) &&
			   preg_match('/^[0-9]+$/', $_POST["editPassID"])){

			   $table = "clients";

			   $data = array('id' => $_POST["idClient"],
			   			     'clientname' => $_POST["editClientName"],
							 'passportid' => $_POST["editPassID"],
							 'email' => $_POST["editEmail"],
							 'contactnum' => $_POST["editContactNumber"],
							 'address' => $_POST["editAddress"],
							 'dateofbirth' => $_POST["editBirthDate"]);

			   $request_to_model = ClientModel::mdlEditClient($table,$data);

			   if ($request_to_model == "success"){

			   	echo '<script>
						
						swal({
							type: "success",
							title: "The Client has been edited succesfully!",
							showConfirmButton: true,
							confirmButtonText: "Close"

						}).then(function(result){

							if(result.value){

								window.location = "customers";
							}

						});
						
						</script>';

			   }


			}else {

				echo '<script>
					
					swal({
						type: "error",
						title: "No special characters or blank fields",
						showConfirmButton: true,
						confirmButtonText: "Close"
			
						}).then(function(result){

							if(result.value){

								window.location = "customers";
							}

						});
					
				</script>';

			}


		}
	}

	/*================================
			DELETE CUSTOMER
	==================================*/

	static public function ctrDeleteClient(){

		if (isset($_GET["idClient"])){

			$table="clients";

			$data = $_GET["idClient"];

			$request = ClientModel::mdlDeleteClient($table,$data);

			if ($request == "success"){

				echo'<script>

				swal({
					  type: "success",
					  title: "The Client has been succesfully deleted",
					  showConfirmButton: true,
					  confirmButtonText: "Close"

					  }).then(function(result){
					  	
						if (result.value) {

						window.location = "customers";

						}
					})

				</script>';

			}
		}

	}



}

