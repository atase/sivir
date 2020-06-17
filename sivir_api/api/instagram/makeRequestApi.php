<?php 

	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');
	header('Access-Control-Allow-Methods: POST');


	include_once '../../config/Database.php';
	include_once '../../models/InstagramSivir.php';


	$database = new Database();
	$db = $database->connect();

	$video = new InstagramSivir($db);

	$object = file_get_contents("php://input");

	$message = [
		'message' => '404'
	];

	$instagram_videos = $video->makeRequestApi($object);
	if($instagram_videos != null){
		$message['message'] = '200';
		$message['data'] = $instagram_videos;
	}
	
	echo json_encode($message);
 ?>