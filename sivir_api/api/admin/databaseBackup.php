<?php  

	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


	include_once '../../config/Database.php';
	include_once '../../models/Admin.php';
	include_once '../../models/YoutubeSivir.php';
	include_once '../../models/InstagramSivir.php';
	include_once '../../models/VimeoSivir.php';
	include_once '../../models/User.php';

	$database = new Database();
	$db = $database->connect();

	$admin = new Admin($db);
	$admin->setYoutube(new YoutubeSivir($db));
	$admin->setInstagram(new InstagramSivir($db));
	$admin->setVimeo(new VimeoSivir($db));
	$admin->setUser(new User($db));

	$path = json_decode(file_get_contents("php://input"));
	$path->path = '..\admin\backup\database'.$path->path;
	@mkdir($path->path);
	$result =  array('message' => '404', 'path' => 'null');



	$save = $admin->saveTables($path->path);
	$save = json_decode($save);

	if($save->success == "true"){
		$result['message'] = '200';
		$result['path'] = $path->path;
	}else{
		$result['message'] = '300';
	}

	echo json_encode($result);


?>