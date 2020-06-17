<?php 
	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');

	include_once '../../config/Database.php';
	include_once '../../models/Admin.php';


	$database = new Database();
	$db = $database->connect();

	$admin = new Admin($db);
	$data = json_decode(file_get_contents("php://input"));

	$admin->setPassword($data->password);
	$admin->setToken($data->token);
	$result = $admin->checkData();

	if($result){
		$admin_arr = array(
			'message' => '200'
		);
	}else{
		$admin_arr = array('message' => '404');
	}
	$data_json = json_encode($admin_arr);
	echo $data_json;
 ?>
