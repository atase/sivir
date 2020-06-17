<?php  

	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');
	header('Access-Control-Allow-Methods: POST');


	include_once '../../config/Database.php';
	include_once '../../models/Admin.php';

	$database = new Database();
	$db = $database->connect();

	$admin = new Admin($db);

	$path = json_decode(file_get_contents("php://input"));
	$path->path = '..\admin\backup\project'.$path->path;
	$result =  array('message' => '404', 'path' => 'null');

	$save = $admin->saveProject($path->path);
	$save = json_decode($save);

	if($save->success == "true"){
		$result['message'] = '200';
		$result['path'] = $path->path;
	}else{
		$result['message'] = '300';
	}

	echo json_encode($result);


?>