<?
class ISSAPI{
	
	private $token 	=	'!@#H3W!@# H3W!@# H3W';	
	private $api_url 	=	'https://issapi.com/audits/v1/';
	private $user_id 	=	false;
	private $client_id 	=	false;
	
	
	function __CONSTRUCT(){
		$this->client_id 	= $_SESSION['_User']->c_id;
		$this->user_id 	= $_SESSION['_User']->u_id;
		
	}	
	
	public function login($email=false, $password=false){
		
		if( !$email  || !$password )
			return false;                               
			
		// SET API ENDPOINT URL	                                     
		$url = $this->api_url.'User';
		
		// ADDITIONAL DATA 
		$data 	=	array();
		$data['action']	= 'login';
		$data['token'] 	=	$this->token;
		$data['email']	= $email;
		$data['password']	= $password;
		$data['user_ip'] = $_SERVER['REMOTE_ADDR'];
			
		// PACK AND SEND	
		$json_data 	= json_encode($data);                                                                               
		$output 		= $this->send($url,$json_data );
		//$result 		= json_decode($output);
		
		//error_log('result in login'.print_r($output,1).print_r($data,1));
		return $output;
	}
	
	public function update($table=false, $id=false, $data=false){
		
		if( !$table  || !$id || !$data)
			return false;                               
			
		// SET API ENDPOINT URL	                                     
		$url = $this->api_url.$table;
		
		// ADDITIONAL DATA 
		$data['action']	= 'update';
		$data['id']			=	$id;
		$data['token'] 	=	$this->token;
		$data['u_id'] 	=	$this->user_id;
		$data['c_id'] 	=	$this->client_id;
		$data['user_ip'] = $_SERVER['REMOTE_ADDR'];
			
		// PACK AND SEND	
		$json_data 	= json_encode($data);                            
		$output 		= $this->send($url,$json_data, $type);
		//$result 		= json_decode($output);
		
		
		return $output;
	}
	
	public function insert($table=false, $data=false){
		if( !$table || !$data)
			return false;                               
			
		// SET API ENDPOINT URL	                                     
		$url = $this->api_url.$table;
		
		// ADDITIONAL DATA 
		$data['action']	= 'insert';
		$data['token'] 	=	$this->token;
		$data['u_id'] 	=	$this->user_id;
		$data['c_id'] 	=	$this->client_id;
		$data['user_ip'] = $_SERVER['REMOTE_ADDR'];
			
		// PACK AND SEND	
		$json_data 	= json_encode($data);                                                                                   
		$output 		= $this->send($url,$json_data, "array");
		
		
		return $output;
	}	

	public function delete($table=false, $id=false, $data=false){		
		if( !$table  || !$id || !$data)
			return false;                               
			
		// SET API ENDPOINT URL	                                     
		$url = $this->api_url.$table;
		
		// ADDITIONAL DATA 
		$data['action']	=	'delete';
		$data['id']			=	$id;
		$data['token'] 	=	$this->token;
		$data['u_id'] 	=	$this->user_id;
		$data['c_id'] 	=	$this->client_id;
		$data['user_ip'] = $_SERVER['REMOTE_ADDR'];
			
		// PACK AND SEND	
		$json_data 	= json_encode($data);                                                                                   
		$output 		= $this->send($url,$json_data, $type);
		
		return $output;
	}		
		
	public function querydb($table=false, $data=false, $type=false){
		
		if( !$table )
			return false;                               
			
		// SET API ENDPOINT URL	                                     
		$url = $this->api_url.$table;
		
		// ADDITIONAL DATA 
		
		$data['action']	= 'query';
		$data['token'] 	=	$this->token;
		$data['u_id'] 	=	$this->user_id;
		$data['c_id'] 	=	$this->client_id;
		$data['user_ip'] = $_SERVER['REMOTE_ADDR'];
			
		// PACK AND SEND	
		$json_data 	= json_encode($data);                                                                                   
		$output 		= $this->send($url,$json_data, $type);
		//$result 		= json_decode($output);
		
		//error_log('result in query'.print_r($output,1).print_r($data,1));
		return $output;
	}
	public function testquerydb($table=false, $data=false, $type=false){
		
		if( !$table )
			return false;                               
			
		// SET API ENDPOINT URL	                                     
			$url = 'http://issapi.com/merge/v1/'.$table;
		
		// ADDITIONAL DATA 
		
		$data['action']	= 'query';
		$data['token'] 	=	'!@#Q3Z!@#H3L!@#H3W';
		$data['u_id'] 	=	'merge';
		$data['c_id'] 	=	$this->client_id;
		$data['user_ip'] = $_SERVER['REMOTE_ADDR'];
			
		// PACK AND SEND	
		$json_data 	= json_encode($data);                                                                                   
		
		
		$output 		= $this->send($url,$json_data, $type);
		//$result 		= json_decode($output);
		
		//error_log('result in query'.print_r($output,1).print_r($data,1));
		return $output;
	}
	
	public function get($table=false, $id=false, $type=false){
		
		if( !$table || !$id )
			return false;                               
			
		// SET API ENDPOINT URL	                                     
		$url = $this->api_url.$table;
		
		// ADDITIONAL DATA 
		$data['action']	= 'get';
		$data['id']	= $id;
		$data['token'] 	=	$this->token;
		$data['u_id'] 	=	$this->user_id;
		$data['c_id'] 	=	$this->client_id;
		$data['user_ip'] = $_SERVER['REMOTE_ADDR'];
			
		// PACK AND SEND	
		$json_data 	= json_encode($data);                                                                                   
		$output 		= $this->send($url,$json_data, $type);
		//$result 		= json_decode($output);
		//mail("jennifer@isecretshop.com","data before send",$action."output=".print_r($output,1));
		//error_log('result in query'.print_r($output,1).print_r($data,1));
		return $output;
	}
	
	private static function send($url,$data, $type=false){
		$ch = curl_init($url);                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json',                                                                                
		'Content-Length: ' . strlen($data))                                                                       
		);            
		$output = curl_exec($ch);
		if ($type=="json")
			return $output;
		else if ($type=="array")	
		{
			if ($output)
				return json_decode($output, 1);
			else return array();
		}
		else	
		 	return json_decode($output);      
	}	
		
}
	
?>