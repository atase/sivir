<?php 

	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


	include_once '../../config/Database.php';
	include_once '../../models/User.php';


	$database = new Database();
	$db = $database->connect();

	$user = new User($db);

	$object = json_decode(file_get_contents("php://input"));

	$result =  array('message' => '404');
	$check = $user->check_data($object);

	if($check){
		$user->first_name = $object->first_name;
		$user->last_name= $object->last_name;
		$user->birth = $object->birth;
		$user->sex = $object->sex;
		$user->email = $object->email;
		$user->username = $object->username;
		$user->password = $object->password;
		$user->profile_pic = "../admin/backup/profile/default.png";

		$result_create = $user->create();

		if($result_create){
			$result['message'] = '200';
		}
	}else{
		$result['message'] = '300';
	}

	echo json_encode($result);

 ?>