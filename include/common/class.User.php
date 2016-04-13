<?

class User{
		
	function login($e, $p, $r=false){
	  import("class.clientAPI");
		global $db;
		// initiate class
		$api =	new ISSAPI();
		$user 	=	$api->login($e,$p);
		//error_log('in login'.$e.' '.$p.print_r($user,1));
	  	  
	  if($user && !$user->error){
		$_SESSION['_User'] = $user;
		
		 if( $r ){
			  $uniqid = uniqid(); 
			  $db->execute("DELETE FROM uniqid WHERE email = '$e'");
			  $q = array(
				  'email' => $e,
				  'password' => $p,
				  'id' => $uniqid,
				  'created_at' => time()
			  );
			  $db->buildInsert($q, 'uniqid');
			  setcookie('uniqid',$uniqid,time()+1209600, '/', 'issaudits.com');
		  }	
		  return true;
	  }
	}
	
	function cookie_validate($e, $p){
		import("class.clientAPI");
		$db = getDB();
		$api =	new ISSAPI();
		$user 	=	$api->login($e,$p);
		if($user){
			$_SESSION['_User'] = $user;
			return true;	
		}
		else
		{
			setcookie('uniqid', '', time()-36000, '/', 'issaudits.com');  
			unset($feedback);
		}
	}
	
	
	
}

?>