<?php 
	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');

	include_once '../../config/Database.php';
	include_once '../../models/User.php';


	$database = new Database();
	$db = $database->connect();

	$user = new User($db);
	$data = json_decode(file_get_contents("php://input"));

	$result = $user->forgotPassword($data->email, $data->firstSecurity, $data->secondSecurity);
	if($result){
		$user_arr = array('message' => '200', 'username' => $user->username, 'password' => $user->password);
	}else{
		$user_arr = array('message' => '404');
	}
	$data_json = json_encode($user_arr);
	echo $data_json;
 ?>