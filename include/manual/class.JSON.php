<?
class JSON{
	
	function update($table=false, $id=false, $data=false){
		
		if( !$table  || !$id || !$data)
			return false;                                                                    
		$url = 'https://isecretshop.com/rssctrl.php?action='.ucwords($table).'Update&USERID=2&PWD='.API_PASSWORD.'&a=1&id='.$id;	
		$json_data = json_encode($data);                                                                                   
		
		
		$ch = curl_init($url);                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		//curl_setopt($ch, CURLOPT_HEADER, true);
		//curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json',                                                                                
		'Content-Length: ' . strlen($json_data))                                                                       
		);                                                                                                                   
		
		//echo $json_data;
		$output = curl_exec($ch);
		
		$result = json_decode($output);
		
		return $result->result;
	}
	
	function insert($table=false, $data=false){
		
		if( !$table  || !$data)
			return false;                                                                    
		$url = 'https://isecretshop.com/rssctrl.php?action='.ucwords($table).'Insert&USERID=2&PWD='.API_PASSWORD.'&a=1';
		
		$json_data = json_encode($data);                                                                                   
		
		
		$ch = curl_init($url);                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		//curl_setopt($ch, CURLOPT_HEADER, true);
		//curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json',                                                                                
		'Content-Length: ' . strlen($json_data))                                                                       
		);                                                                                                                   
		
		//echo $json_data;
		$output = curl_exec($ch);
		
		$result = json_decode($output);
		
		if($result->result)
			return $result->new_id;
		else	
			return false;	
	}
	
	function delete($table=false, $data=false){
		
		if( !$table  || !$data)
			return false;                                                                    
		$url = 'https://isecretshop.com/rssctrl.php?action='.ucwords($table).'Delete&USERID=2&PWD='.API_PASSWORD.'&a=1';	
		//echo $url;
		//print_r($data);
		//exit;
		$json_data = json_encode($data);                                                                                   
		
		
		$ch = curl_init($url);                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		//curl_setopt($ch, CURLOPT_HEADER, true);
		//curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json',                                                                                
		'Content-Length: ' . strlen($json_data))                                                                       
		);                                                                                                                   
		
		//echo $json_data;
		$output = curl_exec($ch);
		
		$result = json_decode($output);
		
		return $result->result;
	}
}
	?>