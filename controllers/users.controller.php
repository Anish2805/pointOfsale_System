<?php
error_reporting(E_ERROR);

class ControllerUsers{

	/*=============================================
	USER LOGIN
	=============================================*/
	
	static public function ctrUserLogin(){


		if (isset($_POST["loginUser"])) {

			// if username contains these characters in the preg match, then echo error notice
			/* if (preg_match('/^[!@#$%^&*() a-zA-Z]+$/', $_POST["loginUser"])){
				
				echo '<br><div class="alert alert-danger">Username Contain special characters or spaces</div>';;
			} */
			
			// if preg_match contains those listed characters give green light
			if (preg_match('/^[a-zA-Z0-9_]+$/', $_POST["loginUser"]) && preg_match('/^[a-zA-Z0-9]+$/', $_POST["loginPass"])){

				//$encryptpass = crypt($_POST["loginPass"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
				
				$table = 'users';

				$item = 'user';
				
				$value = $_POST["loginUser"];

				$answer = UsersModel::MdlShowUsers($table, $item, $value);

				if($answer["user"] == $_POST["loginUser"] && $answer["password"] == $_POST["loginPass"]){

						$_SESSION["loggedIn"] = "ok";
						$_SESSION["id"] = $answer["id"];
						$_SESSION["name"] = $answer["name"];
						$_SESSION["user"] = $answer["user"];
						$_SESSION["photo"] = $answer["photo"];
						$_SESSION["profile"] = $answer["profile"];

						/*=============================================
						Register date to know last_login
						=============================================*/

						date_default_timezone_set("Asia/Kuala_Lumpur");

						$date = date('Y-m-d');
						$hour = date('H:i:s');

						$actualDate = $date.' '.$hour;

						$lastlogin = "last_login";
						$currentdate = $actualDate;

						$id = "id";
						$requestid = $answer["id"];

						$request = UsersModel::mdlUpdateLastLogin($table, $lastlogin, $currentdate, $id, $requestid);

						if($request == "ok"){

							echo '<script>

								window.location = "home";

							</script>';

						}
				}else{

					echo '<br><div class="alert alert-danger">User or password incorrect</div>';
				
				}
			
			}
		
        }
	
	}


	/*=============================================
	CREATE USER
	=============================================*/
	static public function ctrCreateUser(){

		// if the username textbox is set and defined, go to validation with pregmatch 
		if (isset($_POST["newUser"])) {
			
			if (preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["newName"]) &&
				preg_match('/^[a-zA-Z0-9_]+$/', $_POST["newUser"]) &&
				preg_match('/^[a-zA-Z0-9]+$/', $_POST["newPasswd"])){

				/*=============================================
				VALIDATE IMAGE
				=============================================*/

				$photo = "";
			
				if (isset($_FILES["newPhoto"]["tmp_name"])){

					list($width, $height) = getimagesize($_FILES["newPhoto"]["tmp_name"]);
					
					$newWidth = 500;
					$newHeight = 500;

					/*=============================================
					Create the folder for each user
					=============================================*/

					$folder = "views/img/users/".$_POST["newUser"];

					mkdir($folder, 0755);

					/*=============================================
					PHP functions depending on the image
					=============================================*/

					if($_FILES["newPhoto"]["type"] == "image/jpeg"){

						$randomNumber = mt_rand(100,999);
						
						$photo = "views/img/users/".$_POST["newUser"]."/".$randomNumber.".jpg";
						
						$srcImage = imagecreatefromjpeg($_FILES["newPhoto"]["tmp_name"]);
						
						$destination = imagecreatetruecolor($newWidth, $newHeight);

						imagecopyresized($destination, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

						imagejpeg($destination, $photo);

					}

					if ($_FILES["newPhoto"]["type"] == "image/png") {

						$randomNumber = mt_rand(100,999);
						
						$photo = "views/img/users/".$_POST["newUser"]."/".$randomNumber.".png";
						
						$srcImage = imagecreatefrompng($_FILES["newPhoto"]["tmp_name"]);
						
						$destination = imagecreatetruecolor($newWidth, $newHeight);

						imagecopyresized($destination, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

						imagepng($destination, $photo);
					}

				}

				$table = 'users';

				$encryptpass = crypt($_POST["newPasswd"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				$data = array('name' => $_POST["newName"],
							  'user' => $_POST["newUser"],
							  'password' => $_POST["newPasswd"],
							  'profile' => $_POST["newProfile"],
							  'photo' => $photo);

				$answer = UsersModel::mdlAddUser($table, $data);

				if ($answer == 'ok') {

						echo '<script>
						
						swal({
							type: "success",
							title: "The User has been added succesfully!",
							showConfirmButton: true,
							confirmButtonText: "Close"

						}).then(function(result){

							if(result.value){

								window.location = "users";
							}

						});
						
						</script>';

				}
			
			}else{

				echo '<script>
					
					swal({
						type: "error",
						title: "No special characters or blank fields",
						showConfirmButton: true,
						confirmButtonText: "Close"
			
						}).then(function(result){

							if(result.value){

								window.location = "users";
							}

						});
					
				</script>';
			} 
			
		}
	}

	/*=============================================
	SHOW USER
	=============================================*/

	static public function ctrShowUsers($item, $value){

		$table = "users";

		$answer = UsersModel::MdlShowUsers($table, $item, $value);

		return $answer;
	}

	/*=============================================
	SHOW ALL USERS ON DATATABLE
	=============================================*/

	static public function ShowallUsersCtr(){

		$usertable ="users";

		$request = UsersModel::MdlShowAllUsers($usertable);
		return $request;
	}

	/*=============================================
	EDIT USER
	=============================================*/

	static public function ctrEditUser(){

		if (isset($_POST["EditUser"])) {
			
			if (preg_match('/^[a-zA-Z0-9 ]+$/', $_POST["EditName"])){

				/*=============================================
				VALIDATE IMAGE
				=============================================*/

				$photo = $_POST["currentPicture"];

				if(isset($_FILES["editPhoto"]["tmp_name"]) && !empty($_FILES["editPhoto"]["tmp_name"])){

					list($width, $height) = getimagesize($_FILES["editPhoto"]["tmp_name"]);
					
					$newWidth = 500;
					$newHeight = 500;

					/*=============================================
					Create the folder for each user
					=============================================*/

					$folder = "views/img/users/".$_POST["EditUser"];

					/*=============================================
					we ask first if there's an existing image in the database
					=============================================*/

					if (!empty($_POST["currentPicture"])){
						
						unlink($_POST["currentPicture"]);

					}else{

						mkdir($folder, 0755);

					}

					/*=============================================
					PHP functions depending on the image
					=============================================*/

					if($_FILES["editPhoto"]["type"] == "image/jpeg"){

						/*We save the image in the folder*/

						$randomNumber = mt_rand(100,999);
						
						$photo = "views/img/users/".$_POST["EditUser"]."/".$randomNumber.".jpg";
						
						$srcImage = imagecreatefromjpeg($_FILES["editPhoto"]["tmp_name"]);
						
						$destination = imagecreatetruecolor($newWidth, $newHeight);

						imagecopyresized($destination, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

						imagejpeg($destination, $photo);

					}
					
					if ($_FILES["editPhoto"]["type"] == "image/png") {

						/*We save the image in the folder*/

						$randomNumber = mt_rand(100,999);
						
						$photo = "views/img/users/".$_POST["EditUser"]."/".$randomNumber.".png";
						
						$srcImage = imagecreatefrompng($_FILES["editPhoto"]["tmp_name"]);
						
						$destination = imagecreatetruecolor($newWidth, $newHeight);

						imagecopyresized($destination, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

						imagepng($destination, $photo);
					}

				}

				
				$table = 'users';

				if($_POST["EditPasswd"] != ""){

					if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["EditPasswd"])){

						$encryptpass = crypt($_POST["EditPasswd"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

					}

					else{

						echo '<script>
					
							swal({
								type: "error",
								title: "No special characters in the password or blank fields",
								showConfirmButton: true,
								confirmButtonText: "Close"

								}).then(function(result){
										
									if (result.value) {
						
										window.location = "users";

									}
								});
							
						</script>';
					}
				
				}else{

					$encryptpass = $_POST["currentPasswd"];
					
				}

				$data = array('name' => $_POST["EditName"],
								'user' => $_POST["EditUser"],
								'password' => $encryptpass,
								'profile' => $_POST["EditProfile"],
								'photo' => $photo);

				$answer = UsersModel::mdlEditUser($table, $data);

				if ($answer == 'ok') {
					
					echo '<script>
					
						swal({
							type: "success",
							title: "Changes have been made succesfully!",
							showConfirmButton: true,
							confirmButtonText: "Close"

						 }).then(function(result){
							
							if (result.value) {

								window.location = "users";
							}

						});
					
					</script>';
				}
				else{
					echo '<script>
						
						swal({
							type: "error",
							title: "No special characters in the name or blank field",
							showConfirmButton: true,
							confirmButtonText: "Close"
							 }).then(function(result){
									
								if (result.value) {

									window.location = "users";
								
								}

							});
						
					</script>';
				}
			
			}	
		
		}
	
	}

	/*=============================================
	DELETE USER
	=============================================*/

	static public function ctrDeleteUser(){

		if(isset($_GET["userId"])){

			$table ="users";
			$data = $_GET["userId"];

			if($_GET["userPhoto"] != ""){

				unlink($_GET["userPhoto"]);				
				rmdir('views/img/users/'.$_GET["username"]);

			}

			$answer = UsersModel::mdlDeleteUser($table, $data);

			if($answer == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "The user has been succesfully deleted",
					  showConfirmButton: true,
					  confirmButtonText: "Close"

					  }).then(function(result){
					  	
						if (result.value) {

						window.location = "users";

						}
					})

				</script>';

			}		

		}

	}
	
}

