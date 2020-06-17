<?php 
	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');

	include_once '../../config/Database.php';
	include_once '../../models/Admin.php';


	$database = new Database();
	$db = $database->connect();

	$admin = new Admin($db);
	$data = json_decode(file_get_contents("php://input"));
	$result = $admin->check($data->username, $data->password, $data->token);

	if($result){
		$admin_arr = array(
			'message' => '200',
			'valid'   => 'true';
		);
	}else{
		$admin_arr = array('message' => '404', 'valid' => 'false');
	}
	$data_json = json_encode($admin_arr);
	echo $data_json;
 ?>
