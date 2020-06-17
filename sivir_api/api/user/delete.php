<?php 

	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');
	header('Access-Control-Allow-Methods: DELETE');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


	include_once '../../config/Database.php';
	include_once '../../models/User.php';
	include_once '../../models/InstagramSivir.php';
	include_once '../../models/VimeoSivir.php';
	include_once '../../models/YoutubeSivir.php';

	$database = new Database();
	$db = $database->connect();

	$youtube = new YoutubeSivir($db);
	$instagram = new InstagramSivir($db);
	$vimeo = new VimeoSivir($db);
	$user = new User($db);

	$data = json_decode(file_get_contents("php://input"));

	$user->id = $data->id;
	$user->setToken($data->token);

	$message = array("message" => "404");

	if($user->delete()){
		$message['message'] = '200';
		$youtube->user_id = $user->id;
		$instagram->user_id = $user->id;
		$vimeo->user_id = $user->id;

		if(!$youtube->deleteAll()){
			$message['message'] = '300';
		}

		if(!$instagram->deleteAll()){
			$message['message'] = '300';
		}

		if(!$vimeo->deleteAll()){
			$message['message'] = '300';
		}
	}
	echo json_encode($message);
 ?>