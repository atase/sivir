<?php 
	$username = $_POST["username"];
	$password = $_POST["password"];
	$url = "http://localhost/project/sivir_api/api/admin/login.php";

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
		$_SESSION["token"] = $message["token"]; 
		header('Location: ../account.php');
	}else{
		header('Location: ../index.php?auth=0');
	}
?>