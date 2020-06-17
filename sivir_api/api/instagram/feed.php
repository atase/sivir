<?php 
	
	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');

	include_once '../../config/Database.php';
	include_once '../../models/InstagramSivir.php';


	$database = new Database();
	$db = $database->connect();

	$instagramObj = new InstagramSivir($db);

	$channels = fopen("users.txt",'r');
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
		$user = $channelList[array_rand($channelList)];
		if(!in_array($user, $visited)){
			$visited[] = $user;
			$media_url =  $instagramObj->getFeed($user);
			$media_url = json_decode($media_url);
			foreach($media_url as $url){
				array_push($results, $url);
			}
		}
	}
	shuffle($results);
	$message['data'] = $results;
	
	echo json_encode($message);
 ?>