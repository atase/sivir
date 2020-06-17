<?php 

	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');
	header('Access-Control-Allow-Methods: PUT');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


	include_once '../../config/Database.php';
	include_once '../../models/User.php';


	$database = new Database();
	$db = $database->connect();

	$user = new User($db);

	$data = json_decode(file_get_contents("php://input"));

	$user->setToken($data->token);
	$user->id = $data->id;
	$user->first_name = $data->first_name;
	$user->last_name= $data->last_name;
	$user->birth = $data->birth;
	$user->sex = $data->sex;
	$user->email = $data->email;
	$user->username = $data->username;
	$user->password = $data->password;
	$user->profile_pic = $data->profile_pic;
	
	$result = array("message" => "404");

	if($user->update()){
		$result["message"] = "200";
		$result["token"] = $user->getToken();
	}else{
		$result["message"] = "300";
	}

	echo json_encode($result);

 ?>