<?php 
	$username = $_POST["username"];
	$password = $_POST["password"];
	$url = "http://localhost/project/sivir_api/api/user/login.php";

	$data = array(
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
		session_start();
		$_SESSION["id"] = $message['id'];
		$_SESSION["first_name"] = $message['first_name'];
		$_SESSION["last_name"] = $message['last_name'];
		$_SESSION["birth"] = $message['birth'];
		$_SESSION["sex"] = $message['sex'];
		$_SESSION["email"] = $message['email'];
		$_SESSION["username"] = $username;
		$_SESSION["password"] = $password;
		$_SESSION["profile_pic"] = $message['profile_pic'];
		$_SESSION["token"] = $message['token'];
		header('Location: ../index.php?auth=1');
	}else{
		header('Location: ../index.php?auth=0');
	}
?>