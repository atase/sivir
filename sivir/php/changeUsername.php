<?php 
	session_start();


	$new_username = $_POST['new_username'];
	$confirm_new_username = $_POST['confirm_new_username'];

	if(strcmp($new_username,$confirm_new_username) == 0){

		$url = "http://localhost/project/sivir_api/api/user/update.php";

		$data = array(
			"token" => $_SESSION["token"],
			"id" => $_SESSION["id"],
			"first_name" => $_SESSION["first_name"],
			"last_name" => $_SESSION["last_name"],
			"birth" => $_SESSION["birth"],
			"sex" => $_SESSION["sex"],
			"email" => $_SESSION["email"],
			"username" => $new_username,
			"password" => $_SESSION["password"],
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
			$_SESSION['username'] = $new_username;
			header('Location: ../account.php?change_username=1');
		}else{
			header('Location: ../account.php?change_username=0');
		}	
	}else{
		header('Location: ../account.php?invalid=0?change_username=0');
	}	
?>