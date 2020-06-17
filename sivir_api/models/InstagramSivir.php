<?php 
	include_once '..\..\..\API\instagram_api\vendor\autoload.php';

	Class InstagramSivir{
		private $conn;
		private $table='instagram';

		public $user_id;
		public $video_url;

		private $instagram;
		private $medias;
	
		public function __construct($db){
			$this->conn = $db;
			$this->instagram = new \InstagramScraper\Instagram();
		}


		public function create(){
			$query = 'INSERT INTO ' . $this->table . ' SET
				user_id = :user_id,
				video_url = :video_url
			';

			$stmt = $this->conn->prepare($query);
			$this->user_id = htmlspecialchars(strip_tags($this->user_id));
			$this->video_url = htmlspecialchars(strip_tags($this->video_url));

			$stmt->bindParam(":user_id", $this->user_id);
			$stmt->bindParam(":video_url", $this->video_url);

			if($stmt->execute()){
				return true;
			}

			return false;

		}


		public function delete(){
			$query = 'DELETE FROM ' . $this->table . ' WHERE user_id = :user_id AND video_url = :video_url';
			$stmt = $this->conn->prepare($query);

			$this->user_id = htmlspecialchars(strip_tags($this->user_id));
			$this->video_url = htmlspecialchars(strip_tags($this->video_url));

			$stmt->bindParam(":user_id", $this->user_id);
			$stmt->bindParam(":video_url", $this->video_url);

			if($stmt->execute()){
				return true;
			}

			return false;

		}

		public function deleteAll(){

			$this->user_id = htmlspecialchars(strip_tags($this->user_id));

			$query1 = 'SELECT * FROM ' . $this->table . ' WHERE user_id = :user_id';
			$stmt1 = $this->conn->prepare($query1);
			$stmt1->bindParam(":user_id", $this->user_id);
			$stmt1->execute();
			$row = $stmt1->fetchAll();
			if(sizeof($row) == 0){
				return true;
			}
			$query = 'DELETE FROM ' . $this->table . ' WHERE user_id = :user_id';
			$stmt = $this->conn->prepare($query);

			$this->user_id = htmlspecialchars(strip_tags($this->user_id));

			$stmt->bindParam(":user_id", $this->user_id);

			if($stmt->execute()){
				return true;
			}

			return false;

		}

		public function getVideos(){
			$query = 'SELECT * FROM ' . $this->table . ' WHERE user_id = :user_id';
			$stmt = $this->conn->prepare($query);

			$this->user_id = htmlspecialchars(strip_tags($this->user_id));
			$stmt->bindParam(":user_id", $this->user_id);

			$data = array('message' => '404', 'videos' => array());

			if($stmt->execute()){
				$data['message'] = '200';
				$index = 0;
				while($row = $stmt->fetch()){
					$data['videos'][$index] = $row['video_url'];
					$index++;
				}
			}else{
				$data['message'] = '300';
			}
		
			return json_encode($data);

		}

		public function makeRequestApi($params){

			$params = json_decode($params);
			$list_query_params = $params->query_params;
			$results = [];
			$emotion = "";
			if($list_query_params->emotion != "none"){
				if(strcmp($list_query_params->emotion, "sad") == 0){
					$emotion = "happy";
				}else if(strcmp($list_query_params->emotion, "bored") == 0){
					$emotion = "mistery";
				}
				else if(strcmp($list_query_params->emotion, "nervous") == 0){
					$emotion = "funny";
				}else{
					$emotion = "happy";
				}
				$this->medias = $this->instagram->getMediasByTag($emotion,15);
				foreach($this->medias as $item){
					if($item->getType()){
						array_push($results, $item->getLink());
					}
				}
			}

			if($list_query_params->tags!= "none"){
				$this->medias = $this->instagram->getMediasByTag($list_query_params->tags,20);
				foreach($this->medias as $item){
					if($item->getType()){
						array_push($results, $item->getLink());
					}
				}
			}

			if($list_query_params->title!= "none"){
				$this->medias = $this->instagram->getMediasByTag($list_query_params->title,15);
				foreach($this->medias as $item){
					if($item->getType()){
						array_push($results, $item->getLink());
					}
				}
			}

			if($list_query_params->description!= "none"){
				$params = explode(' ',$list_query_params->description);
				$this->medias = $this->instagram->getMediasByTag($list_query_params->$params[0],15);
				foreach($this->medias as $item){
					if($item->getType()){
						array_push($results, $item->getLink());
					}
				}
			}

			if($list_query_params->country!= "none"){
				$this->medias = $this->instagram->getMediasByTag($list_query_params->country,15);
				foreach($this->medias as $item){
					if($item->getType()){
						array_push($results, $item->getLink());
					}
				}
			}

			if($list_query_params->length!= "none"){
				$this->medias = $this->instagram->getMediasByTag("time",15);
				foreach($this->medias as $item){
					if($item->getType()){
						array_push($results, $item->getLink());
					}
				}
			}

			return $results;
		}

		public function getFeed($user){
			$user = str_replace("\r","",$user);
			$user = str_replace("\n","",$user);
			$results = [];
			$this->medias = $this->instagram->getMedias($user, 10);
			foreach($this->medias as $media){
				array_push($results, $media->getLink());
			}

			return json_encode($results);
		}

		public function getTable(){
			$query = 'SELECT * FROM ' . $this->table;

			$stmt = $this->conn->prepare($query);

			$data = array('message' => '404', 
				'table' => array());

			if($stmt->execute()){
				$data['message'] = '200';
				$index = 0;
				while($row = $stmt->fetch()){
					$item = array( 
					$row['user_id'],
					$row['video_url']);
					$data['table'][$index] = $item;
					$index++;
				}
			}else{
				$data['message'] = '300';
			}
		
			return json_encode($data);
		}

	}



 ?>