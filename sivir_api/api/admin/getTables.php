<?php  

	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');
	header('Access-Control-Allow-Methods: GET');
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


	$result =  array('message' => '404', 'result' => 'null');

	$export = $admin->getTables();
	$export = json_decode($export);

	if($export->success == "true"){
		$result['message'] = '200';
		$result['result'] = $export->data; 
	}else{
		$result['message'] = '300';
		$result['result'] = $export->data;
	}

	echo json_encode($result);


?>