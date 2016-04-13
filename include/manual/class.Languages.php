<?

class Languages{
	
	function get($code){
		$db = getDB();
		$d = $db->query("SELECT id
						FROM languages
						WHERE code = '".trim($code)."'
						");
		
		return $d[0][id];
	}
	
	function get_list(){
		$db = getDB();
		$l = $db->query("SELECT *
						FROM languages
						WHERE id != 0
						ORDER BY name ASC");
		return $l;
	}
	
	function get_select_list(){
		$db = getDB();
		$t = Languages::get_list();
		if($t)foreach($t as $v)
			$l[$v['code']] = $v['name'];
		unset($t);
		return $l;
	}
	
	function get_additional_select(){
		$db = getDB();
		$l = Languages::get_select_list();
		unset($l[en_US]);
		return $l;
	}	
	
	function get_section($id, $code, $default=false)
	{
		$db = getDB();
		$l = $db->query("SELECT *
						FROM section_languages
						WHERE section_id = '$id'
						AND language_code = '$code'");
		echo $db->error();				
		return $l[0][name];				
	}
	
	function get_question($id, $code, $default=false)
	{
		$db = getDB();
		$l = $db->query("SELECT *
						FROM question_lang
						WHERE question_id = $id
						AND language_code = '$code'");
		echo $db->error();				
		return $l[0];				
	}
	
	function get_question_set($id)
	{
		$db = getDB();
		$t = $db->query("SELECT *
						FROM question_lang
						WHERE question_id = '$id'");
		
		if($t)foreach($t as $v)
			$l[$v['language_code']] = $v;
		unset($t);
		return $l;		
				
	}
	
	function get_font($code)
	{
		$db = getDB();
		$l = $db->query("SELECT font
						FROM languages
						WHERE code = '".trim($code)."'
						");
		
		
		return $l[0][font];		
			
				
	}
	
	
}

?>