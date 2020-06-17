<?php 
	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');
	header('Access-Control-Allow-Methods: DELETE');


	include_once '../../config/Database.php';
	include_once '../../models/VimeoSivir.php';


	$database = new Database();
	$db = $database->connect();

	$video = new VimeoSivir($db);

	$object = json_decode(file_get_contents("php://input"));

	$video->user_id = $object->user_id;
	$video->video_url = $object->video_url;

	$message = array('message' => '404');

	if($video->delete()){
		$message['message'] = '200';
	}else{
		$message['message'] = '300';
	}
	echo json_encode($message);


 ?>