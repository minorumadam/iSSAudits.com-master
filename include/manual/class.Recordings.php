<?

class Recordings{
	
	function get($id){
		$db = getDB();
		if( !$id )
			return false;

		
		$d = $db->query("SELECT recordings.*,
						shops.name,
						shops.client_id,
						shops.recorded,
						locations.address AS l_address,
						locations.city AS l_city,
						locations.state AS l_state,
						locations.zip AS l_zip,
						locations.latitude,
						locations.longitude,
						locations.name AS l_name,
						locations.phone AS l_phone,
						locations.hours,
						locations.notify_emails,
						clients.company AS client,
						clients.msp_id
						FROM recordings
						JOIN shop_instances ON shop_instances.id = recordings.shop_instances_id
						JOIN shoppers ON shoppers.id = shop_instances.shopper_id
						JOIN shops ON shops.id = shop_instances.shop_id
						JOIN clients ON clients.id = shops.client_id
						JOIN locations ON locations.id = shop_instances.location_id
						WHERE recordings.id = '$id'
						");
		$d = $d[0];
		return $d;
		
	}
	
	
	

	
	function show($files){
		
		
		$db = getDB();
		
	
		
		if ($files) foreach ($files as $file)
				//	if (strpos($file,$filename))  //if the filename is part of the file but NOT at the beginning (time stamp is first)
					{
	
						$html .= "	<object type='application/x-shockwave-flash' data='https://www.isecretshop.com/images/media/player_mp3_mini.swf' width='200' height='20'>
						<param name='movie' value='https://www.isecretshop.com/player_mp3_mini.swf' />
	<param name='bgcolor' value='189ca8' />
						<param name='FlashVars' value='mp3=https://".$file->s3_host."/".$file->s3_bucket."/".$file->s3_path."' />
						</object>"; 
					
						$html .= "<BR><BR>";       			
					$count++;
					}
					
        return $html;        		
	}
	
	function count_files($shop)
	{
		$dir = $_SERVER['DOCUMENT_ROOT']."/uploads/clients/".$shop->shop[client_id]."/shops/".$shop->id."/";
		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				$count=0;
				while (($file = readdir($dh)) !== false) {
					$filename = ".mp3";
					if (strpos($file,$filename))  
					{     			
						$count++;
					}
					
				}
				closedir($dh);
			}
		}
		return $count;
	}
	
	
	
	//this doesn't work because iSS does not allow blank pages...
	function remote_file_exists($url) {
		$curl = curl_init($url);
	
		//don't fetch the actual page, you only want to check the connection is ok
		curl_setopt($curl, CURLOPT_NOBODY, true);
	
		//do request
		$result = curl_exec($curl);
	
		$ret = false;
	
		//if request did not fail
		if ($result !== false) {
			//if request was ok, check response code
			$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  
			echo $url;
			if ($statusCode == 200) {
				$ret = true;   
			}
		}
	
		curl_close($curl);
	
		return $ret;
	}
	function remote_file_mp3($url) {
		$ch = curl_init($url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_exec($ch);
		if (curl_getinfo($ch, CURLINFO_CONTENT_TYPE)=="audio/mpeg")
			return true;
		else
			return false;	
		//return curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
	}
		
}

?>