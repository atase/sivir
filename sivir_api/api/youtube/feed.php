<?php 
	
	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');


	include_once '../../config/Database.php';
	include_once '../../models/YoutubeSivir.php';


	$database = new Database();
	$db = $database->connect();

	$youtubeObj = new YoutubeSivir($db);

	$channels = fopen("channels.txt",'r');
	$body = file_get_contents("php://input");
	$body = json_decode($body);

	$message['user_id'] = $body->user_id;
	$message['message'] = '200';
	$results = [];
	$channelList = [];
	$visited = [];
	while(!feof($channels)){
		$channelList[] = fgets($channels);
	}

	fclose($channels);


	for($index = 0; $index < 3; $index++){
		$xmlChannel = $channelList[array_rand($channelList)];
		if(!in_array($xmlChannel, $visited)){
			$visited[] = $xmlChannel;
			$video_ids =  $youtubeObj->getFeed($xmlChannel);

			$video_ids = json_decode($video_ids, true);
			foreach($video_ids as $id){
				array_push($results, $id);
			}
		}
	}

	shuffle($results);
	$message['data'] = $results;	
	echo json_encode($message);
 ?>