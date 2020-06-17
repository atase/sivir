<?php  

Class User{
	private $conn;
	private $table = 'users';

	public $id;
	public $first_name;
	public $last_name;
	public $birth;
	public $sex;	
	public $email;
	public $username;
	public $password;
	public $profile_pic;

	private $key = "094b777007cd09b5c2bf8521f94d0ca4719ba093e26e0a8a68cba77e4b853019vf8H93M9ZA";
	private $token;

	public $vimeo;
	public $instagram;
	public $youtube;

	public function __construct($db){
		$this->conn = $db;
	}

	public function setToken($newToken){
		$this->token = $newToken;
	}

	public function getToken(){
		return $this->token;
	}


	private function checkToken(){
		$query = 'SELECT * FROM ' . $this->table;
		$stmt = $this->conn->prepare($query);
		if($stmt->execute()){
			while($row = $stmt->fetch()){
				$checkT = hash("sha256", $row['first_name'].$row['email']);
				if($this->token == $checkT && $this->id == $row['id']){
					return true;
				}
			}
			return false;
		}
		return false;
	}


	public function login(){
		$query = 'SELECT * FROM ' . $this->table . ' WHERE username = ? and password = ?';
		$this->username = htmlspecialchars(strip_tags($this->username));
		$this->password = htmlspecialchars(strip_tags($this->password));
		$this->username = $this->encryptData($this->username);
		$this->password = $this->encryptData($this->password);
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1,$this->username, PDO::PARAM_STR);
		$stmt->bindParam(2,$this->password, PDO::PARAM_STR);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row){
			$this->id = $row['id'];
			$this->first_name = $this->decryptData($row['first_name']);
			$this->last_name = $this->decryptData($row['last_name']);
			$this->email = $this->decryptData($row['email']);
			$this->birth = $row['birth'];
			$this->sex = $row['sex'];
			$this->username = $this->decryptData($row['username']);
			$this->password = $this->decryptData($row['password']);
			$this->profile_pic = $row['profile_pic'];
			$this->token = hash("sha256", $row['first_name'].$row['email']);
			return true;
		}
		return false;	
	}

	public function getId(){
		$query = 'SELECT * FROM ' . $this->table . ' WHERE username = ? and password = ?';
		$this->username = htmlspecialchars(strip_tags($this->username));
		$this->password = htmlspecialchars(strip_tags($this->password));
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1,$this->username, PDO::PARAM_STR);
		$stmt->bindParam(2,$this->password, PDO::PARAM_STR);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row){
			$this->id = $row['id'];
			return $this->id;
		}
		return 'none';
	}

	public function create(){
		$query = 'INSERT INTO ' . $this->table . ' SET
					first_name = :first_name,
					last_name = :last_name,
					birth = :birth,
					sex = :sex,
					email = :email,
					username = :username,
					password = :password,
					profile_pic = :profile_pic
						';

		$stmt = $this->conn->prepare($query);
		$this->first_name = htmlspecialchars(strip_tags($this->first_name));
		$this->last_name = htmlspecialchars(strip_tags($this->last_name));
		$this->birth = htmlspecialchars(strip_tags($this->birth));
		$this->sex = htmlspecialchars(strip_tags($this->sex));
		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->username = htmlspecialchars(strip_tags($this->username));
		$this->password = htmlspecialchars(strip_tags($this->password));


		$this->first_name = $this->encryptData($this->first_name);
		$this->last_name = $this->encryptData($this->last_name);
		$this->email = $this->encryptData($this->email);
		$this->username = $this->encryptData($this->username);
		$this->password = $this->encryptData($this->password);

		$stmt->bindParam(':first_name', $this->first_name);
		$stmt->bindParam(':last_name', $this->last_name);
		$stmt->bindParam(':birth', $this->birth);
		$stmt->bindParam(':sex', $this->sex);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':username', $this->username);
		$stmt->bindParam(':password', $this->password);
		$stmt->bindParam(':profile_pic', $this->profile_pic);

		if($stmt->execute()){
		 
			return true;
		}
		return false;

	}

	public function getData(){

		$data=[
			"first_name" => $this->first_name,
			"last_name" => $this->last_name,
			"birth" => $this->birth,
			"sex" => $this->sex,
			"email" => $this->email,
			"username" => $this->username,
			"password" => $this->password
		];

		return $data;
	}


	public function update(){

		if(!$this->checkToken()){
			return false;
		}

		$query = 'UPDATE ' . $this->table . ' SET
					first_name = :first_name,
					last_name = :last_name,
					birth = :birth,
					sex = :sex,
					email = :email,
					username = :username,
					password = :password,
					profile_pic = :profile_pic
				WHERE id = :id';

		$stmt = $this->conn->prepare($query);
		$this->id = htmlspecialchars(strip_tags($this->id));
		$this->first_name = htmlspecialchars(strip_tags($this->first_name));
		$this->last_name = htmlspecialchars(strip_tags($this->last_name));
		$this->birth = htmlspecialchars(strip_tags($this->birth));
		$this->sex = htmlspecialchars(strip_tags($this->sex));
		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->username = htmlspecialchars(strip_tags($this->username));
		$this->password = htmlspecialchars(strip_tags($this->password));


		$this->first_name = $this->encryptData($this->first_name);
		$this->last_name = $this->encryptData($this->last_name);
		$this->email = $this->encryptData($this->email);
		$this->username = $this->encryptData($this->username);
		$this->password = $this->encryptData($this->password);

		$stmt->bindParam(':id', $this->id);
		$stmt->bindParam(':first_name', $this->first_name);
		$stmt->bindParam(':last_name', $this->last_name);
		$stmt->bindParam(':birth', $this->birth);
		$stmt->bindParam(':sex', $this->sex);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':username', $this->username);
		$stmt->bindParam(':password', $this->password);
		$stmt->bindParam(':profile_pic', $this->profile_pic);

		if($stmt->execute()){
			$this->token = hash("sha256", $this->first_name.$this->email);
			$this->first_name = $this->decryptData($this->first_name);
			$this->last_name = $this->decryptData($this->last_name);
			$this->email = $this->decryptData($this->email);
			$this->username = $this->decryptData($this->username);
			$this->password = $this->decryptData($this->password);
			return true;
		}

		return false;

	}

	public function delete(){

		if(!$this->checkToken()){
			return false;
		}

		//Create query
		$query = 'DELETE FROM ' . $this->table . ' WHERE id= :id';

		//Prepare statement
		$stmt = $this->conn->prepare($query);
		
		//Clear data
		$this->id = htmlspecialchars(strip_tags($this->id));

		//Bind data
		$stmt->bindParam(':id', $this->id);

		//Execute query
		if($stmt->execute()){
			return true;
		}
		return false;

	}

	/*

	first_name = :first_name,
					last_name = :last_name,
					birth = :birth,
					sex = :sex,
					email = :email,
					username = :username,
					password = :password,
					profile_pic = :profile_pic*/

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
					$this->decryptData($row['first_name']),
					$this->decryptData($row['last_name']),
					$row['birth'],
					$row['sex'],
					$this->decryptData($row['email']),
					$row['profile_pic'],
					$this->decryptData($row['username']),
					$this->decryptData($row['password']));
					$data['table'][$index] = $item;
					$index++;
				}
			}else{
				$data['message'] = '300';
			}
		
			return json_encode($data);
		}

	public function forgotPassword($mail, $security1, $security2){


		$query = 'SELECT * FROM ' . $this->table . ' WHERE email = ? and birth = ? and last_name = ?';

		$stmt = $this->conn->prepare($query);
		$mail = htmlspecialchars(strip_tags($mail));
		$security1 = htmlspecialchars(strip_tags($security1));
		$security2 = htmlspecialchars(strip_tags($security2));
		$mail = $this->encryptData($mail);
		$security2 = $this->encryptData($security2);
		$stmt->bindParam(1, $mail, PDO::PARAM_STR);
		$stmt->bindParam(2, $security1, PDO::PARAM_STR);
		$stmt->bindParam(3, $security2, PDO::PARAM_STR);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row){
			$this->username = $this->decryptData($row['username']);
			$this->password = $this->decryptData($row['password']);
			return true;
		}
		return false;
		
	}

	public function check_data($object){

		$object->email = htmlspecialchars(strip_tags($object->email));
		$object->username = htmlspecialchars(strip_tags($object->username));

		$object->email = $this->encryptData($object->email);
		$object->username = $this->encryptData($object->username);

		$query1 = 'SELECT * FROM ' . $this->table . ' WHERE email = ? ';
		$query2 = 'SELECT * FROM ' . $this->table . ' WHERE username = ? ';
		$stmt1 = $this->conn->prepare($query1);
		$stmt2 = $this->conn->prepare($query2);
		$stmt1->bindParam(1, $object->email, PDO::PARAM_STR);
		$stmt2->bindParam(1, $object->username, PDO::PARAM_STR);

		if($stmt1->execute()){
			$row = $stmt1->fetch(PDO::FETCH_ASSOC);
			if($row){
				$object->email = $this->decryptData($object->email);
				$object->username = $this->decryptData($object->username);
				return false;
			}
		}else{
			$object->email = $this->decryptData($object->email);
			$object->username = $this->decryptData($object->username);
			return false;
		}

		if($stmt2->execute()){
			$row = $stmt2->fetch(PDO::FETCH_ASSOC);
			if($row){
				$object->email = $this->decryptData($object->email);
				$object->username = $this->decryptData($object->username);
				return false;
			}
		}else{
			$object->email = $this->decryptData($object->email);
			$object->username = $this->decryptData($object->username);
			return false;
		}

		$object->email = $this->decryptData($object->email);
		$object->username = $this->decryptData($object->username);

		return true;
	}


	private function encryptData($string){
		$ciphering = "AES-256-CBC";
		$iv_length = openssl_cipher_iv_length($ciphering);
		$encryption_iv = '9859473847527364';
		$encryption = openssl_encrypt($string, $ciphering, $this->key, 0,$encryption_iv);
		return $encryption;
	}

	private function decryptData($string){
		$ciphering = "AES-256-CBC";
		$iv_length = openssl_cipher_iv_length($ciphering);
		$encryption_iv = '9859473847527364';
		$encryption = openssl_decrypt($string, $ciphering, $this->key, 0,$encryption_iv);
		return $encryption;
	}

}

?>