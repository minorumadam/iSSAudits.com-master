<?



///////////////////////////////////////////////////////

//////  THIS CODE DEVELOPED BY BENJAMIN PITTMAN ///////

//////              www.bpittman.com            ///////

///////////////////////////////////////////////////////



// Build out a table of all results of the query //



class MySqlDB{

	

	public $link = false;

	public $db = DB_NAME;

	public $host = DB_HOST;

	public $pass = DB_PASSWORD;

	public $user = DB_USERNAME;

	

	public $last_query = '';

	

	function query($query){

		if( !$this->link )

	  		$this->connect();

	  

		$result = mysql_db_query($this->db, $query, $this->link);

		$err = mysql_error($this->link);

		$data = array();

		if(!$err){

			while($row = @mysql_fetch_assoc($result)) {

			  $data[] = $row;

			}

		}

		elseif(defined('DEBUG') && DEBUG)

		{

			print("<pre>Error executing query:\n$query\nMysql error:\n$err\n</pre>");

		}

		$this->last_query = $query;

		return $data;

	}

	

	function query_row($query){

		$data = $this->query($query);

		

		if(is_array($data))

			return reset($data);



		return null;

	}

	

	function query_value($query){

		$row = $this->query_row($query);

		

		if(is_array($row))

			return reset($row);



		return null;

	}

	

	function query_values($query){

		$values = array();

		foreach( $this->query($query) as $row)

			$values[] = reset($row);



		return $values;

	}



	

	function execute($query){

		if( !$this->link )

	  		$this->connect();

		$result = mysql_db_query($this->db, $query, $this->link);

		if( !$result ){

			return false;

		}

		$this->last_query = $query;

		return $result;

	}

	

	function fetch($result){

		return mysql_fetch_assoc($result);

	}

	

	function connect(){

		$conn = mysql_connect($this->host, $this->user, $this->pass);

		if( $conn ){

	  		$this->link = $conn;

			return true;

		}

	}

	

	function close(){

		if( $this->link )

			mysql_close($this->link);

		$this->link = false;

	}

	

	function error(){

		return mysql_error($this->link);

	}

	function affected_rows(){

		return mysql_affected_rows($this->link);

	}

	function insert_id(){

		return mysql_insert_id($this->link);

	}

	

	function check_sql_command($string){

	  if($string == 'now()') return true;

	  if($string == 'NULL') return true;

	}

	

	// Build an INSERT query by passing an array //

	function buildInsert($array, $where, $exec=true){

	  $query = '';

	  $query .= "INSERT INTO `".$where."` (";

	  $counter = 0;

	  foreach($array as $k=>$v){

		if($counter == 0){

		  $counter++;

		  $query .= '`'.$k.'`';

		}

		else{

		  $query .= ', `'.$k.'`';

		}

	  }

	  $query.= ") VALUES(";

	  $counter = 0;

	  foreach($array as $k=>$v){

		if(is_array($v)) $v = serialize($v);

		if($counter == 0){

		  $counter++;

		  if($this->check_sql_command($v)) $query .= $v;

		  else $query .= "'".addslashes($v)."'";

		}

		else{

		  if($this->check_sql_command($v)) $query .= ", ".$v;

		  else $query .= ", '".addslashes($v)."'";

		}

	  }

	  $query.= ")";

	  if( $exec ){

	    if( $this->execute($query) )

			return true;

	  }

	  else

	    return $query;

	}

	// Build an UPDATE query by passing an array //

	function buildUpdate($array, $where, $extra='', $exec=true){

	  $query .= "UPDATE ".$where." SET ";

	  $counter = 0;

	  foreach($array as $k=>$v){

		if(is_array($v)) $v = serialize($v);

		if($counter == 0){

		  $counter++;

		  if($this->check_sql_command($v)) $query .= "`".$k."` = ".$v."";

		  else $query .= "`".$k."` = '".addslashes($v)."'";

		}

		else{

		  if($this->check_sql_command($v)) $query .= ", "."`".$k."` = ".$v."";

		  else $query .= ", "."`".$k."` = '".addslashes($v)."' ";

		}

	  }reset($array);

	  $query.= ' '.$extra;

	  if( $exec ){

	    if( $this->execute($query) )

			return true;

	  }

	  else

	    return $query;

	}

	

	// Build a WHERE statement based on an array

	function buildWhere($array){

	  $result = array();

	  if(is_array($array)){

		foreach($array as $k=>$v){

		  $where .= $separator;

		  if(is_array($v)){

			$where .= '('.buildWhere($v).')';

		  }

		  else $where .= $v;

		  if(!$separator) $separator = " AND ";

		}//end foreach($array)

	  }// end if(is_array($array))

	  return $where;

	}

	

	function delete($table, $what = array()){

	  $sql = "DELETE FROM `$table`";

	  if($what) {

	  	$sql .= " WHERE ";

	  	foreach ($what as $key => $value) 

	  		$sql .= " `$key` = '".mysql_real_escape_string($value)."' AND ";	  	

	  }



	  $sql = preg_replace("% AND $%", '', $sql);



	  $this->query($sql);

	}

	

	function select($table, $what = array()){

	  $sql = "SELECT * FROM `$table`";

	  if($what) {

	  	$sql .= " WHERE ";

	  	foreach ($what as $key => $value) 

	  		$sql .= " `$key` = '".mysql_real_escape_string($value)."' AND ";	  	

	  }



	  $sql = preg_replace("% AND $%", '', $sql);



	  return $this->query($sql);

	}

	

	function select_value($table, $field_name, $what = array()){

	  $sql = "SELECT `".mysql_real_escape_string($field_name)."` FROM `$table`";

	  if($what) {

	  	$sql .= " WHERE ";

	  	foreach ($what as $key => $value) 

	  		$sql .= " `$key` = '".mysql_real_escape_string($value)."' AND ";	  	

	  }



	  $sql = preg_replace("% AND $%", '', $sql);



	  return $this->query_value($sql);

	}

	

	function select_row($table, $what = array()){

	  $sql = "SELECT * FROM `$table`";

	  if($what) {

	  	$sql .= " WHERE ";

	  	foreach ($what as $key => $value) 

	  		$sql .= " `$key` = '".mysql_real_escape_string($value)."' AND ";	  	

	  }



	  $sql = preg_replace("% AND $%", '', $sql);



	  return $this->query_row($sql);

	}

	

	function last(){

		return $this->last_query;

	}

	

}



function getDB(){

	global $db;

	if( !$db )

		$db = new MySQLDB;

	$db->db = DB_NAME;

	$db->host = DB_HOST;

	$db->pass = DB_PASSWORD;

	$db->user = DB_USERNAME;	

	

	//$db->close();

	$db->connect();	

	return $db;

}

/*

function getDB2(){

	global $db2;

	if( !$db2 )

		$db2 = new MySQLDB;

	$db2->db = DB_NAME2;

	$db2->host = DB_HOST2;

	$db2->pass = DB_PASSWORD2;

	$db2->user = DB_USERNAME2;

	//$db2->close();

	$db2->connect();



	return $db2;

}

*/



?>