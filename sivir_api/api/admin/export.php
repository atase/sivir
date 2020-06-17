<?php  

	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');
	header('Access-Control-Allow-Methods: POST');


	include_once '../../config/Database.php';
	include_once '../../models/Admin.php';
	include_once '../../models/YoutubeSivir.php';
	include_once '../../models/InstagramSivir.php';
	include_once '../../models/VimeoSivir.php';
	include_once '../../models/User.php';

	$database = new Database();
	$db = $database->connect();

	$admin = new Admin($db);

	$data = json_decode(file_get_contents("php://input"));
	if($data->youtube == '1'){
		$admin->setYoutube(new YoutubeSivir($db));
	}
	if($data->instagram == '1'){
		$admin->setInstagram(new InstagramSivir($db));
	}
	if($data->vimeo == '1'){
		$admin->setVimeo(new VimeoSivir($db));
	}
	if($data->user == '1'){
		$admin->setUser(new User($db));
	}
	$data->path = '..\admin\backup\export'.$data->path;
	@mkdir($data->path);
	$result =  array('message' => '404', 'path' => 'null');
	$export = $admin->exportCSV($data->path);



	if($export){
		$result['message'] = '200';
		$result['path'] = $data->path; 
	}else{
		$result['message'] = '300';
	}

	echo json_encode($result);


?>