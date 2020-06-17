<?php 

	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');

	include_once '../../config/Database.php';
	include_once '../../models/VimeoSivir.php';

	$database = new Database();
	$db = $database->connect();

	$channels = fopen("channels.txt",'r');
	$body = file_get_contents("php://input");
	$body = json_decode($body);
	$video = new VimeoSivir($db);


	$message['user_id'] = $body->user_id;
	$message['message'] = '200';
	$results = [];
	$channelList = [];
	$visited = [];
	while(!feof($channels)){
		$channelList[] = fgets($channels);
	}

	fclose($channels);

	for($index = 0; $index < 4; $index++){
		$channel_id = $channelList[array_rand($channelList)];
		if(!in_array($channel_id, $visited)){
			$visited[] = $channel_id;
			$vimeo_feed = $video->getFeed($channel_id);
			$vimeo_feed = json_decode($vimeo_feed,true);
			foreach($vimeo_feed['body']['data'] as $item){
				$videoId = explode("/", $item['uri']);
				array_push($results, $videoId[2]);
			}
		}
	}

	shuffle($results);
	$message['data'] = $results;
	
	echo json_encode($message);
 ?>