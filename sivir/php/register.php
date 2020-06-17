<?php 

	$firstName = $lastName = $birth = $sex = $email = $username = $password = "";
	$firstNameErr = $lastNameErr = $birthErr = $sexErr = $emailErr = $usernameErr = $passwordErr = "";



	$firstName = $_POST["first_name"];
	$lastName = $_POST["last_name"];
	$birth = $_POST["birth"];
	$sex = $_POST["sex"];
	$email = $_POST["email"];
	$username = $_POST["username"];
	$password = $_POST["password"];
	
	$url = "http://localhost/project/sivir_api/api/user/create.php";


	$data = array(
		"first_name" => $firstName,
		"last_name" => $lastName,
		"birth" => $birth,
		"sex" => $sex,
		"email" => $email,
		"username" => $username,
		"password" => $password
	);

	$data_json = json_encode($data);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
	$result = curl_exec($curl);
	curl_close($curl);
	$message = json_decode($result, true);
	
	if($message['message'] == '200'){
		header('Location: ../index.php?reg=1');
	}else if($message['message'] == '300'){
		header('Location: ../index.php?reg=0');
	}
 ?>	