<?php 
	session_start();

	$new_profile_pic = $_FILES['profile_picture']['name'];
	$new_profile_pic = $_SESSION["id"].$new_profile_pic;
	$_path_profile_pic = "/project/sivir_api/api/admin/backup/profile/".$new_profile_pic;
	$target_dir = "../../sivir_api/api/admin/backup/profile/";
	$target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    	header('Location: ../account.php?change_profile_pic=0');
	}
	move_uploaded_file($_FILES['profile_picture']['tmp_name'],$target_dir.$new_profile_pic);


	$url = "http://localhost/project/sivir_api/api/user/update.php";

	$data = array(
		"token" => $_SESSION["token"],
		"id" => $_SESSION["id"],
		"first_name" => $_SESSION["first_name"],
		"last_name" => $_SESSION["last_name"],
		"birth" => $_SESSION["birth"],
		"sex" => $_SESSION["sex"],
		"email" => $_SESSION["email"],
		"username" => $_SESSION["username"],
		"password" => $_SESSION["password"],
		"profile_pic" => $_path_profile_pic
	);

	$data_json = json_encode($data);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
	$result = curl_exec($curl);
	curl_close($curl);

	$message = json_decode($result, true);
	if($message['message'] == '200'){
		$_SESSION['profile_pic'] = $_path_profile_pic;
		header('Location: ../account.php?change_profile_pic=1');
	}else{
		header('Location: ../account.php?change_profile_pic=0');
	}

 ?>