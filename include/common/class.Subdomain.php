<?

class Subdomain{
	
	
	/*function get_by_name($name){
		$name = addslashes($name);
		$db = getDB();
		$d = $db->query("
		SELECT *
		FROM clients
		WHERE subdomain = '$name'
		");
		if( $d ){
			$d = $d[0];
			return $d;
		}
	}*/
	
	function get_subdomain(){
		$_z = explode('.', $_SERVER['HTTP_HOST']);
		if( $_z[0] == 'www' )
			$_z = strtolower($_z[1]);
		else
			$_z = strtolower($_z[0]);
		if( $_z && $_z != 'www' && $_z != 'issaudits'){
			return $_z;
		}
		else
			return false;
	}
	
	
	
	
	function background(){
		if( $this->background || $this->background_color ){
			$b = 'background:';
			if( $this->background )
				$b .= 'url(\'/' . $this->background . '\') top center ' . $this->background_repeat . ' ';
			if( $this->background_color )
				$b .= $this->background_color;
			$b .= ';';
		}//end if($this->background...	
		return $b;
	}

	

}

?>