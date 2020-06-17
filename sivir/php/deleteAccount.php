<?php 
	session_start();
	$userId = $_SESSION["id"];

	$url = "http://localhost/project/sivir_api/api/user/delete.php";

	$data = array(
		"token" => $_SESSION["token"],
		"id" => $userId
	);
	$data_json = json_encode($data);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
	$result = curl_exec($curl);
	curl_close($curl);

	$message = json_decode($result, true);
	if($message["message"] == "200"){
		session_destroy();
		header('Location: ../index.php?del=1');
	}else {
		header('Location: ../account.php?del=0');
	}
 ?>
