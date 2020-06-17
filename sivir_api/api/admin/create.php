<?php 

	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


	include_once '../../config/Database.php';
	include_once '../../models/Admin.php';


	$database = new Database();
	$db = $database->connect();

	$admin = new Admin($db);

	$object = json_decode(file_get_contents("php://input"));

	$result =  array('message' => '404', 'result' => 'null');
	

	$admin->setEmail($object->email);
	$admin->setUsername($object->username);
	$admin->setPassword($object->password);
	$admin->setToken($object->token);
	$result_create = $admin->create();

	if($result_create){
		$result['message'] = '200';
	}else{
		$result['message'] = '300';
	}

	echo json_encode($result);

 ?>