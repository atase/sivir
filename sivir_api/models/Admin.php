<?php 
	Class Admin{
		private $conn;
		private $table = 'admin';

		private $src_project = '..\..\..\sivir';
		private $dst_project = '..\..\..\sivir';
		private $id;
		private $username;
		private $password;
		private $email; 

		private $youtube;
		private $instagram;
		private $vimeo;
		private $user;

		private $token;
		private $generator;

		private $secret = "094b777007cd09b5c2bf8521f94d0ca4719ba093e26e0a8a68cba77e4b853019vf8H93M9ZA";


		public function __construct($db){
			$this->conn = $db;
		}

		public function getId(){
			return $this->id;
		}

		public function getUsername(){
			return $this->username;
		}

		public function getPassword(){
			return $this->password;
		}

		public function getEmail(){
			return $this->email;
		}

		public function getToken(){
			return $this->token;
		}

		public function setToken($newToken){
			$this->token = $newToken;
		}

		public function setYoutube($newYoutube){
			$this->youtube = $newYoutube;
		}

		public function setInstagram($newInstagram){
			$this->instagram = $newInstagram;
		}

		public function setVimeo($newVimeo){
			$this->vimeo = $newVimeo;
		}

		public function setUser($newUser){
			$this->user = $newUser;
		}

		public function setUserName($newUsername){
			$this->username = $newUsername;
		}

		public function setPassword($newPassword){
			$this->password = $newPassword;
		}

		public function setEmail($newEmail){
			$this->email = $newEmail;
		}

		private function checkToken(){
		$query = 'SELECT * FROM ' . $this->table;
		$stmt = $this->conn->prepare($query);
		if($stmt->execute()){
			while($row = $stmt->fetch()){
				$checkT = hash("sha256", $row['id'].$row['username'].$row['email']).hash("sha256",$this->secret);
				if($this->token == $checkT ){
					return true;
				}
			}
			return false;
		}
		return false;
	}

		public function login(){
			$query = 'SELECT * FROM ' . $this->table . ' WHERE username = ? and password = ?';

			$stmt = $this->conn->prepare($query);
			$this->username = hash("sha256", $this->username);
			$this->password = hash("sha256", $this->password);
			$stmt->bindParam(1,$this->username, PDO::PARAM_STR);
			$stmt->bindParam(2,$this->password, PDO::PARAM_STR);
			$stmt->execute();

			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if($row){
				$this->token = hash("sha256", $row['id'].$row['username'].$row['email']).hash("sha256", $this->secret);
				return true;
			}
			return false;	
		}

		public function create(){

			if(!$this->checkToken()){
				return false;
			}

			$query = 'INSERT INTO ' . $this->table . ' SET
						email = :email,
						username = :username,
						password = :password
							';

			$stmt = $this->conn->prepare($query);
			$this->email = htmlspecialchars(strip_tags($this->email));
			$this->username = htmlspecialchars(strip_tags($this->username));
			$this->password = htmlspecialchars(strip_tags($this->password));
			$this->email = hash("sha256", $this->email);
			$this->username = hash("sha256", $this->username);
			$this->password = hash("sha256", $this->password);
			$stmt->bindParam(':email', $this->email);
			$stmt->bindParam(':username', $this->username);
			$stmt->bindParam(':password', $this->password);

			if($stmt->execute()){
				return true;
			}
			return false;

		}

		public function saveProject($path){
			$result = array('success' => 'true');
			if($this->recursive_copy($this->src_project,$path)){
				return json_encode($result);
			}
			$result['success'] = 'false';
			return json_encode($result);
		}

		public function restoreProject($path){
			$path = $path . '/';
			if(!is_dir($path)){
				return false;
			}
			if($this->recursive_copy($path,$this->dst_project)){
				return true;
			}
			return false;
		}

		private function recursive_copy($src, $path){
			$project = opendir($src);
			@mkdir($path);
			while(false !== ($file = readdir($project))){
				if(($file != '.') && ($file != '..')){
					if(is_dir($src.'/'.$file)){
						$this->recursive_copy($src.'/'.$file, $path.'/'.$file);
					}else{
						copy($src.'/'.$file, $path.'/'.$file);
					}
				}
			}
			return true;
		}
		

		public function exportCSV($filename){

			if($this->user != null){
				$result = $this->exportData($this->user, $filename.'\\user.csv');
				if($result == false){
					return false;
				}
			}

			if($this->youtube != null){
				$result = $this->exportData($this->youtube, $filename.'\\youtube.csv');
				if($result == false){
					return false;
				}
			}

			if($this->instagram != null){
				$result = $this->exportData($this->instagram, $filename.'\\instagram.csv');
				if($result == false){
					return false;
				}
			}

			if($this->vimeo != null){
				$result = $this->exportData($this->vimeo, $filename.'\\vimeo.csv');
				if($result == false){
					return false;
				}
			}

			return true;
		}

		private function exportData($object, $filename){
			$data = $object->getTable();
			$data = json_decode($data,true);
			if(!($file = fopen($filename,"w"))){
				return false;
			}
			foreach($data['table'] as $item){
				if(!fputcsv($file, $item)){
					return false;
				}
			}
			fclose($file);
			return true;
		}

		public function saveTables($path){
			$data = $this->getTables();
			$data = json_decode($data, true);
			$result = array('success' => 'true');
			/*
				user -> youtube -> instagram -> vimeo

			*/
			
			$ytfile = fopen($path.'/youtube.json', 'w');
			$vmfile = fopen($path.'/vimeo.json','w');
			$itfile = fopen($path.'/instagram.json','w');
			$usfile = fopen($path.'/users.json','w');

			if(!fwrite($ytfile,json_encode($data['data']['youtube']))){
				$result['success'] = 'false';
			}

			if(!fwrite($vmfile, json_encode($data['data']['vimeo']))){
				$result['success'] = 'false';
			}

			if(!fwrite($itfile, json_encode($data['data']['instagram']))){
				$result['success'] = 'false';
			}

			if(!fwrite($usfile, json_encode($data['data']['users']))){
				$result['success'] = 'false';
			}

			return json_encode($result);
		}

		public function getTables(){
			$result = array('success' => 'true', 
				'data' => [
				'users' => array(),
				'youtube' => array(),
				'instagram' => array(),
				'vimeo' => array()
				]);
			$youtube_table = $this->youtube->getTable();
			$instagram_table = $this->instagram->getTable();
			$vimeo_table = $this->vimeo->getTable();
			$users_table = $this->user->getTable();

			$youtube_table = json_decode($youtube_table);
			$instagram_table = json_decode($instagram_table);
			$vimeo_table = json_decode($vimeo_table);
			$users_table = json_decode($users_table);

			foreach($users_table->table as $row){
				$object = "";
				foreach($row as $item){
					$object = $object . $item . ' ';
				}
				array_push($result['data']['users'], $object);
			}

			foreach($instagram_table->table as $row){
				$object = "";
				foreach($row as $item){
					$object = $object . $item . ' ';
				}
				array_push($result['data']['instagram'], $object);
			}

			foreach($youtube_table->table as $row){
				$object = "";
				foreach($row as $item){
					$object = $object . $item . ' ';
				}
				array_push($result['data']['youtube'], $object);
			}

			foreach($vimeo_table->table as $row){
				$object = "";
				foreach($row as $item){
					$object = $object . $item . ' ';
				}
				array_push($result['data']['vimeo'], $object);
			}

			return json_encode($result);

		}

		private function dropTables(){
			$DANGER_u = 'DELETE FROM users WHERE id >= 0';
			$DANGER_y = 'DELETE FROM youtube WHERE id >= 0';
			$DANGER_i = 'DELETE FROM instagram WHERE id >= 0';
			$DANGER_v = 'DELETE FROM vimeo WHERE id >= 0';

			$STMT_u = $this->conn->prepare($DANGER_u);
			$STMT_y = $this->conn->prepare($DANGER_y);
			$STMT_v = $this->conn->prepare($DANGER_v);
			$STMT_i = $this->conn->prepare($DANGER_i);

			if(!($STMT_u->execute())){
				return false;
			}

			if(!($STMT_y->execute())){
				return false;
			}

			if(!($STMT_v->execute())){
				return false;
			}

			if(!($STMT_i->execute())){
				return false;
			}

			return true;
		}

		public function restoreTables($path){
			$path = $path. "/";
			if(!is_dir($path)){
				return false;
			}
			if(!($this->dropTables())){
				return false;
			}

			$backup_tables = scandir($path);
			
			$youtube_backup = fopen($path.$backup_tables[5], 'r');
			$instagram_backup = fopen($path.$backup_tables[2], 'r');
			$vimeo_backup = fopen($path.$backup_tables[4], 'r');
			$user_backup = fopen($path.$backup_tables[3], 'r');

			$youtube_contents = fread($youtube_backup, filesize($path.$backup_tables[5]));
			$instagram_contents = fread($instagram_backup, filesize($path.$backup_tables[2]));
			$vimeo_contents = fread($vimeo_backup, filesize($path.$backup_tables[4]));
			$user_contents = fread($user_backup, filesize($path.$backup_tables[3]));

			fclose($youtube_backup);
			fclose($instagram_backup);
			fclose($vimeo_backup);
			fclose($user_backup);


			$user_contents = json_decode($user_contents, true);

			foreach($user_contents as $data){
				$data = explode(' ', $data);
				$this->user->first_name = $data[0];
				$this->user->last_name= $data[1];
				$this->user->birth = $data[2];
				$this->user->sex = $data[3];
				$this->user->email = $data[4];
				$this->user->profile_pic = $data[5];
				$this->user->username = $data[6];
				$this->user->password = $data[7];
				if(!($this->user->create())){
					return false;
				}
			}
			$this->user->id = $this->user->getId();
			if($this->user->id == 'none'){
				return false;
			}
			$youtube_contents = json_decode($youtube_contents, true);
			foreach($youtube_contents as $data){
				$data = explode(' ', $data);
				$this->youtube->user_id = $this->user->id;
				$this->youtube->video_url = $data[1];
				if(!($this->youtube->create())){
					return false;
				}
			}

			$instagram_contents = json_decode($instagram_contents, true);
			foreach($instagram_contents as $data){
				$data = explode(' ', $data);
				$this->instagram->user_id = $this->user->id;
				$this->instagram->video_url = $data[1];
				if(!($this->instagram->create())){
					return false;
				}
			}

			$vimeo_contents = json_decode($vimeo_contents, true);
			foreach($vimeo_contents as $data){
				$data = explode(' ', $data);
				$this->vimeo->user_id = $this->user->id;
				$this->vimeo->video_url = $data[1];
				if(!($this->vimeo->create())){
					return false;
				}
			}

			return true;
		}


		public function apiStructure(){
			$dir = '..\..\..\sivir_api';
			$results = $this->getDirContents($dir);
			return json_encode(array('structure' => $results));
		}

		public function projectStructure(){
			$dir = '..\..\..\sivir';
			$results = $this->getDirContents($dir);
			return json_encode(array('structure' => $results));
		}


		private function getDirContents($dir){

			$parts = explode('\\', $dir);
			$structure = ['path' => $parts[sizeof($parts)-1], 'folders' => [], 'files' => []];
			$files = scandir($dir);
			$folder_data = array();
			foreach($files as $key => $value){
				$path = $dir . DIRECTORY_SEPARATOR . $value;
				if(!is_dir($path)){
					if((strcmp($dir, "..\..\..\sivir_api\api\admin\backup\profile")) != 0){
						$handler = fopen($path, 'r');
						$file_data = fread($handler, filesize($path));
						fclose($handler);
						$structure['files'][] =  array('path' => $value, 'data' =>$file_data);
					}
				}
			}
			foreach($files as $key => $value){
				$path = $dir . DIRECTORY_SEPARATOR . $value;
				if(is_dir($path) && $value != '.' && $value != '..'){
					$structure['folders'][] =  $this->getDirContents($path);
				}
			}
			return $structure;
		}

		private function getDirFolder($dir){
			$files = scandir($dir);
			$structure[$dir] = array('folders' => array(), 'files' => array());
			foreach($files as $key => $value){
				$path = $dir . DIRECTORY_SEPARATOR . $value;
				if(is_dir($path) && $value != '.' && $value != '..'){
					$structure[$dir]['folders'][$path] = array();
				}else{
					$structure[$dir]['files'][$path] = 'data';
				}
			}
		}

		private function isFileImage($path){
			if(getimagesize($path)){
			   return true;
			}
			   return false;
		}

		private function generateToken($n) { 
		    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
		    $token = ''; 
		  
		    for ($i = 0; $i < $n; $i++) { 
		        $index = rand(0, strlen($characters) - 1); 
		        $token .= $characters[$index]; 
		    } 
		  
		    return $token; 
		}


		public function checkData(){
			$query = 'SELECT * FROM ' . $this->table;

			$stmt = $this->conn->prepare($query);
			
			if($stmt->execute()){

				while($row = $stmt->fetch()){
					$generateToken = hash("sha256", $row['id'].$row['username'].$row['email']).hash("sha256", $this->secret);
					if($this->token == $generateToken && $row['password'] == hash("sha256", $this->password)){
						return true;
					}
				}
			}
			return false;
		} 

	}


 ?>