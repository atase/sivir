<?php 
	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');
	header('Access-Control-Allow-Methods: GET');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


	include_once '../../config/Database.php';
	include_once '../../models/InstagramSivir.php';


	$database = new Database();
	$db = $database->connect();

	$video = new InstagramSivir($db);

	$object = json_decode(file_get_contents("php://input"));

	$video->user_id = $object->user_id;

	$data = $video->getVideos();

	echo $data;

 ?>