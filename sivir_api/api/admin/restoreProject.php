<?php  

	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');
	header('Access-Control-Allow-Methods: GET');


	include_once '../../config/Database.php';
	include_once '../../models/Admin.php';

	$database = new Database();
	$db = $database->connect();

	$admin = new Admin($db);

	$path = json_decode(file_get_contents("php://input"));
	$path->path = "backup\project".$path->path;
	$result =  array('message' => '404','path' => $path->path);



	$restore = $admin->restoreProject($path->path);

	if($restore){
		$result['message'] = '200';
	}else{
		$result['message'] = '300';
	}

	echo json_encode($result);


?>