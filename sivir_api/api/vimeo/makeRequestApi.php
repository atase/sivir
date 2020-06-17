<?php 

	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');
	header('Access-Control-Allow-Methods: POST');


	include_once '../../config/Database.php';
	include_once '../../models/VimeoSivir.php';


	$database = new Database();
	$db = $database->connect();

	$video = new VimeoSivir($db);

	$object = file_get_contents("php://input");

	$message = [
		'message' => '404'
	];

	$vimeo_videos = $video->makeRequestApi($object);

	if($vimeo_videos != null){
		$message['message'] = '200';
		$results = [];
		$vimeo_videos = json_decode($vimeo_videos,true);

		foreach($vimeo_videos['body']['data'] as $item){
			$videoId = explode("/", $item['uri']);
			array_push($results, $videoId[2]);
		}

		$message['data'] = $results;
	}
	
	echo json_encode($message);
 ?>