<?php 
	session_start();


	$new_password = $_POST['new_password'];
	$confirm_new_password = $_POST['confirm_new_password'];

	if(strcmp($new_password,$confirm_new_password) == 0){

		$url = "http://localhost/project/sivir_api/api/user/update.php";

		$data = array(
			"token" => $_SESSION["token"],
			"id" => $_SESSION["id"],
			"first_name" => $_SESSION["first_name"],
			"last_name" => $_SESSION["last_name"],
			"birth" => $_SESSION["birth"],
			"sex" => $_SESSION["sex"],
			"email" => $_SESSION["email"],
			"username" => $_SESSION["username"],
			"password" => $new_password,
			"profile_pic" => $_SESSION["profile_pic"]
		);

		$data_json = json_encode($data);
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
		$result = curl_exec($curl);
		curl_close($curl);

		$message = json_decode($result, true);
		if($message['message'] == '200'){
			$_SESSION['token'] = $message['token'];
			$_SESSION['password'] = $new_password;
			header('Location: ../account.php?change_password=1');
		}else{
			header('Location: ../account.php?change_password=0');
		}
	}else{
		header('Location: ../account.php?change_password=0');
	}
?>