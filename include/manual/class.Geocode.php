<?

class Geocode{

	function get($address=false, $city=false, $state=false, $zip=false, $country="US"){
		//$xmlstr = 'http://maps.google.com/maps/geo?q=' . urlencode($address . ', ' . $city . ', ' . $state . ' ' . $zip) . '&output=xml&key=' . GOOGLE_API_KEY;
		$components = "&components=country:".urlencode($country);
		if ($zip && ($country =="US" || $country =="CA")) $components .= "|postal_code:".urlencode($zip);
		if ($state) $components .= "|state:".urlencode($state);
		$details_url = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address . ', ' . $city ).$components. '&sensor=false';
		$ch = curl_init();
	   	curl_setopt($ch, CURLOPT_URL, $details_url);
	   	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	   	$response = json_decode(curl_exec($ch), true);
		//mail("jennifer@isecretshop.com","geocode first attempt",$details_url." ".print_r($response,1)." ".$_SERVER['REQUEST_URI'] );
		if ($response['status'] == 'OVER_QUERY_LIMIT') {
			mail("jennifer@isecretshop.com","ge0code over limit",$details_url." ".print_r($response,1)." ".$_SERVER['REQUEST_URI'] );
			
		
			
		}
		//
		//mail("jennifer@isecretshop.com","ge0code",$details_url." ".print_r($response,1)." ".$_SERVER['REQUEST_URI'] );
			
		// if response is not ok - try without the address - just city state zip
		if ($response['status'] != 'OK') {
			
			$details_url = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($city . ', ' . $state . ' ' . $zip. ' '.$country) . '&sensor=false';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $details_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response = json_decode(curl_exec($ch), true);
		   }
		//mail("jennifer@isecretshop.com","shopper",$details_url.print_r($array,1));
		 if ($response['status'] != 'OK') {
			 mail("jennifer@isecretshop.com","ge0code",$details_url." ".print_r($response,1)." ".$_SERVER['REQUEST_URI'] );
			return null;
		   }	 
	  // print_r($response);
	   $geometry = $response['results'][0]['geometry'];
	   $address = $response['results'][0]['address_components'];

		$array = array(
			'latitude' => str_replace(",",".",$geometry['location']['lat']),
			'longitude' => str_replace(",",".",$geometry['location']['lng']),
			'location_type' => $geometry['location_type'],
			'address' =>$address[0][short_name].' '.$address[1][short_name],
			'city' => $address[2][short_name],
			'state' => $address[4][short_name],
			'country' => $address[5][short_name],
			'zip' => $address[6][short_name],
		);
		return $array;
	}
	
	function get_client_side($address, $url)
	{
		$geocode_java = " <script src='".($_SERVER['HTTP_HOST']?"https://":"http://")."maps.google.com/maps/api/js?".($_SERVER['HTTP_HOST']?"v=3&sensor=false":"sensor=false")."'
           type='text/javascript'></script> 
           
		   <script type='text/javascript'> 
			window.addEvent('domready', function(){
	 			var geocoder = new google.maps.Geocoder();
	 			var strAddess;
				
      			if (geocoder) {
         			geocoder.geocode({ 'address': '$address' }, function (results, status) {
            			if (status == google.maps.GeocoderStatus.OK) {
							var latitude=results[0].geometry.location.lat();
							var longitude=results[0].geometry.location.lng();
							window.location.href = '$url?lat='+latitude+'&lon='+longitude;
            			} 
            			else {
							window.location.href = '$url';
            			}
         		});
      		}
			});
		</script> ";
   		echo $geocode_java;
	}
	
	function get_client_side_jquery($address, $url)
	{
		$geocode_java = " <script src='".($_SERVER['HTTP_HOST']?"https://":"http://")."maps.google.com/maps/api/js?".($_SERVER['HTTP_HOST']?"v=3&sensor=false":"sensor=false")."'
           type='text/javascript'></script> 
           
		   <script type='text/javascript'> 
			$(document).ready(function() {
	 			var geocoder = new google.maps.Geocoder();
	 			var strAddess;
				
      			if (geocoder) {
         			geocoder.geocode({ 'address': '$address' }, function (results, status) {
            			if (status == google.maps.GeocoderStatus.OK) {
							var latitude=results[0].geometry.location.lat();
							var longitude=results[0].geometry.location.lng();
							window.location.href = '$url?lat='+latitude+'&lon='+longitude;
            			} 
            			else {
							window.location.href = '$url';
            			}
         		});
      		}
			});
		</script> ";
   		echo $geocode_java;
	}
	
	function getGps($exifCoord, $hemi) {

			$degrees = count($exifCoord) > 0 ? Geocode::gps2Num($exifCoord[0]) : 0;
			$minutes = count($exifCoord) > 1 ? Geocode::gps2Num($exifCoord[1]) : 0;
			$seconds = count($exifCoord) > 2 ? Geocode::gps2Num($exifCoord[2]) : 0;
		
			$flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;
		
			return $flip * ($degrees + $minutes / 60 + $seconds / 3600);
		
	  }
	  
	  function gps2Num($coordPart) {
	  
		  $parts = explode('/', $coordPart);
	  
		  if (count($parts) <= 0)
			  return 0;
	  
		  if (count($parts) == 1)
			  return $parts[0];
	  
		  return floatval($parts[0]) / floatval($parts[1]);
	  }
	  
}

?>