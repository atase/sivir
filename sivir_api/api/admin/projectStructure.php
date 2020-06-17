<?php 

	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');
	header('Access-Control-Allow-Methods: GET');


	include_once '../../config/Database.php';
	include_once '../../models/Admin.php';


	$database = new Database();
	$db = $database->connect();

	$admin = new Admin($db);

	$result =  array('message' => '404', 'result' => array());
	
	if($result_create = $admin->projectStructure()){
		$result['message'] = '200';
		$result['result'] = json_decode($result_create, true); 
	}else{
		$result['message'] = '300';
	}

	echo json_encode($result);

 ?>