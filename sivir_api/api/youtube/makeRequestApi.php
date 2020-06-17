<?php 

	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');


	include_once '../../config/Database.php';
	include_once '../../models/YoutubeSivir.php';


	$database = new Database();
	$db = $database->connect();

	$video = new YoutubeSivir($db);

	$object = file_get_contents("php://input");

	$message = [
		'message' => '404'
	];
	$video->setQueryParams($object);
	$youtube_videos = $video->makeRequestApi();
	//$message['data'] = $youtube_videos;
	if($youtube_videos != null){
		$message['message'] = '200';
		$results = [];
		foreach($youtube_videos as $item){
			array_push($results, $item);
		}
	}

	$message['data'] = $results;
	
	echo json_encode($message);
 ?>