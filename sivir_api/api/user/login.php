<?php 
	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');

	include_once '../../config/Database.php';
	include_once '../../models/User.php';


	$database = new Database();
	$db = $database->connect();

	$user = new User($db);
	$data = json_decode(file_get_contents("php://input"));

	$user->username = $data->username;
	$user->password = $data->password;

	$result = $user->login();

	if($result){
		$user_arr = array(
			'message' => '200',
			'id' => $user->id,
			'first_name' => $user->first_name,
			'last_name' => $user->last_name,
			'birth' => $user->birth,
			'sex' => $user->sex,
			'email' => $user->email,
			'username' => $user->username,
			'password' => $user->password,
			'profile_pic' => $user->profile_pic,
			'token' => $user->getToken()
		);
	}else{
		$user_arr = array('message' => '404');
	}
	$data_json = json_encode($user_arr);
	echo ($data_json);
 ?>