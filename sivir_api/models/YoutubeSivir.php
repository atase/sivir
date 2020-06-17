<?php 
	include_once '..\..\..\API\google_api\vendor\autoload.php';


	Class YoutubeSivir{
		private $conn;
		private $table='youtube';

		public $user_id;
		public $video_url;
		private $id;
		
		private $client;
		private $service;
		private $q_params;
		private $response;
		private $regionCodes = array(
			"Romania" => "RO",
			"America" => "US",
			"US" => "US",
			"United Kingdom" => "UK" 
		);


	
		public function __construct($db){
			$this->conn = $db;

			$this->client = new Google_Client();
			$this->client->setApplicationName("Sivir");
			$this->client->setScopes(['https://www.googleapis.com/auth/youtube.readonly',]);
			$this->client->setDeveloperKey('AIzaSyCXCs1kQqvbxDFUzyr0oAB-8BkkkpXILUw');
			$this->service = new Google_Service_YouTube($this->client);
			$this->response = [];
			$this->q_params = [];
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

		public function makeRequestApi(){

			$entry_response = $this->service->search->listSearch('id,snippet', $this->q_params);
			
			foreach($entry_response->items as $item){
				array_push($this->response, $item->id->videoId);
			}

			return $this->response;
						
		}

		public function setQueryParams($params){
			$params = json_decode($params);
			$list_query_params = $params->query_params;

			$orders = ['date','rating','relevance','title','videoCount','viewCount'];

			$order = $orders[array_rand($orders)];
			
			$this->q_params['order']=$order;
			$this->q_params['maxResults'] = 35;
			$this->q_params['type'] = 'video';
			$this->q_params['videoEmbeddable'] = 'true';

			if($list_query_params->length != "none"){
				$this->q_params['videoDuration'] = $list_query_params->length;
			}

			if($list_query_params->emotion != "none"){
				if(strcmp($list_query_params->emotion, "sad") == 0){
					$this->q_params['q'] = array("happy","joy","love");
				}else if(strcmp($list_query_params->emotion, "bored") == 0){
					$this->q_params['q'] = array("action","adventure","mystery");
				}
				else if(strcmp($list_query_params->emotion, "nervous") == 0){
					$this->q_params['q'] = array("relax","joy","sleep");
				}else{
					$this->q_params['q'] = array($list_query_params->emotion);
				}


			}

			if($list_query_params->country!= "none"){
				$this->q_params['regionCode'] = $this->regionCodes[$list_query_params->country];
			}

			if($list_query_params->tags!= "none"){
				$this->q_params['q'][]=$list_query_params->tags;
			}
			if($list_query_params->title!= "none"){
				$this->q_params['q'][] =  $list_query_params->title;
			}

			if($list_query_params->description != "none"){
				$this->q_params['q'][] = $list_query_params->description;
			}
		}

		public function getFeed($xmlChannel){
			$xmlChannel = str_replace("\r","",$xmlChannel);
			$xmlChannel = str_replace("\n","",$xmlChannel);
			$url = "https://www.youtube.com/feeds/videos.xml?";
			$xmlDoc = $url.$xmlChannel;
			$rssFeed = simplexml_load_file($xmlDoc);
			$results = [];
			foreach($rssFeed->entry as $item){
				$video_id = explode(':',$item->id);
				array_push($results, $video_id[2]);
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