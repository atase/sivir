<?php 
	include_once '..\..\..\API\vimeo_api\vendor\autoload.php';
	use Vimeo\Vimeo;

	Class VimeoSivir{
		private $conn;
		private $table='vimeo';

		public $user_id;
		public $video_url;

		private $client;
		private $response;

		private $query_params;


		public function __construct($db){
			$this->conn = $db;
			$this->client = new Vimeo("35cb6f841a18ff6129a1d826f0a6c2a2faa54261",
				"loA9c7Gl/8NwaMXMm7dQgJXWdMfC/0AZ/stSsfGrw8BJ36psuD4LfWSpCSECDO622jU9lBuwsOmvVqKAkjKu66vtfHC2gzc+18K7lsYLw14zBXsNp/Nb8tRNtk/OsIsL", 
				"8e382564e7176173b3b5745745b38947");
			$this->query_params = [];
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
			$query_string = '';

    		$this->query_params['page'] = rand(1,30);
    		$this->query_params['per_page'] = '30';
    		$this->query_params['sort'] = 'relevant';

			if($list_query_params->emotion != "none"){
				if(strcmp($list_query_params->emotion, "sad") == 0){
					$query_string .= ' joy';
					$query_string .= ' happy';
				}else if(strcmp($list_query_params->emotion, "bored") == 0){
					$query_string .= ' action';
					$query_string .= ' adventure';
				}else if(strcmp($list_query_params->emotion, "nervous") == 0){
					$query_string .= ' relax';
					$query_string .= ' sleep';
				}else{
					$query_string .= ' '.$list_query_params->emotion;
				}

			}

			if($list_query_params->tags!= "none"){
				$query_string .= ' '.$list_query_params->tags;
			}

			if($list_query_params->title!= "none"){
				$query_string .= ' '.$list_query_params->title;
			}

			if($list_query_params->description != "none"){
				$params = explode(' ',$list_query_params->description);
				$query_string .= ' '.$params[0];
			}

			if($list_query_params->country != "none"){
				$query_string .= ' '.$list_query_params->country;
			}

			if($list_query_params->length != "none"){
				$query_string .= ' time';
			}



			$this->query_params['query'] = $query_string;
			$this->response = $this->client->request('/videos', $this->query_params);

			return json_encode($this->response);
		}

		public function getFeed($channelId){
			$channelId = str_replace("\r","",$channelId);
			$channelId = str_replace("\n","",$channelId);
			$this->response = $this->client->request('/channels/'.$channelId.'/videos',['per_page' => 10],'GET');
			return json_encode($this->response);
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