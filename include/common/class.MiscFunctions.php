<?

class MiscFunctions{

	function get_cards_by_location($loc){
		global $db;
		if( !$db )
			$db = new MySQLDB;
		if( !$loc || !is_numeric($loc) )
			return false;
		$l = $db->query("
			SELECT comment_cards.*,
			shoppers.first_name,
			shoppers.last_name,
			shoppers.email,
			shoppers.city,
			shoppers.state
			FROM comment_cards
			LEFT JOIN shoppers ON comment_cards.shopper_id = shoppers.id
			WHERE location_id = '$loc'
			ORDER BY created_at DESC
		");
		return $l;
	}
	
	
	function answer_types($card=false){
		
		$types = array(
			'picker' => 'picker',
			'segmented' => 'segmented',
			'text' => 'text',
			'number' => 'number',
			'currency' => 'currency',
			'receipt' => 'receipt',
			'datetime' => 'datetime',
			'date' => 'date',
			'time' => 'time',
			'elapsed' => 'elapsed time',
			'info' => 'informational',
			'photo' => 'photo',
			'check_all' => 'check all that apply',
			'aggregate' => 'aggregate',
		//	'formula' => 'formula',
			'price' => 'price audit'
		
		);
	
		return $types;
	}
	
	function type_is_multiple_choice($type){
		if( $type == 'picker' || $type == 'segmented' || $type == 'price'|| $type == 'check_all' )
			return true;
		else
			return false;
	}
	
	function format_answer($answer, $type){
		import ("class.TimeZones");
		if (strlen($answer)>0)
		{
			if( $type == 'datetime' )
			{
				if (is_numeric($answer))
					$answer = date("l, F d, Y", $answer-TimeZones::getoffset()) . ' at ' . date("g:ia", $answer-TimeZones::getoffset());
				else
				{
					$answer = MiscFunctions::localize_timedate($answer);
				}
			}
			else if( $type == 'time' )
			{
				if (is_numeric($answer))
					$answer = date("g:ia", $answer-TimeZones::getoffset());
				else
				{
					$answer = date("g:ia", strtotime($answer));
				}
			}
			else if( $type == 'date' )
			{
				if (is_numeric($answer))
					$answer = date("l, F d, Y", $answer-TimeZones::getoffset());
				else
				{
					$answer = MiscFunctions::localize_date($answer);
				}
			}
			else if( $type == 'price' )
				$answer = money_format("$%i", $answer);	
			else if( $type == 'text' )
				$answer = nl2br($answer);	
			else if( $type == 'currency' || $type == 'receipt' )
				$answer = money_format("$%i", $answer);		
			else if( $type == 'number' )
				$answer = $answer;	
			else if( $type == 'photo' )
				$answer = 'See Image';		
			else if( $type == 'elapsed' )
			{	
				$hours = floor($answer/3600);
				$minutes = floor(($answer-($hours*3600))/60);			
				$seconds = $answer-($hours*3600)-($minutes*60);
				$answer="";
				if ($hours)
					$answer .= $hours." hours ";
				if ($hours OR $minutes)
					$answer .= $minutes." minutes and ";	
				$answer .= $seconds ." seconds"; 	
			}
		}
		return $answer;
	}
	

	function parse_answers($answers){
		$l = explode("\n", $answers);
		$answers = array();
		$counter = 1;
		if($l)foreach($l as $k=>$v)
			if( strlen(trim($v)) ){
				$answers[$counter] = trim($v);
				$counter++;
			}
		return $answers;
	}
	//Parse Options makes the option and index the same ie [No]= No
	function parse_options($answers){
		$l = explode("\n", $answers);
		$answers = array();
		
		if($l)foreach($l as $k=>$v)
			if( strlen(trim($v)) ){
				$answers[trim($v)] = trim($v);
			}
		return $answers;
	}
	
	function un_parse_answers($answers){
		//echo ($answers);
		//$answers=utf8_encode($answers);
		if(($answers)and is_array($answers)) foreach ($answers as $k=>$v)
			$new_answers.=$v."\n";
		return $new_answers;		
	}
	
	function format_answers($answers){
		$html_answers = "";
		if(($answers)and is_array($answers)) foreach($answers as $k=>$v)
			if( $v ){
				$html_answers.=trim($v)."<BR>";
			}
		return $html_answers;
	}
	
	function check_na($answer){
	
		if (($answer == 'NA')||($answer == 'N/A')||($answer == 'Not Applicable')||($answer == 'na')||($answer == 'n/a'))
			return true;
		else
			return false;	
	}
	

	function group_field_name($group){
		if ($group=="level_1" || $group=="level_2" || $group=="level_3") return 'level_id';
		else if ($group=="report_name") return 'location_id';
		else if ($group=="shop_name") return 'shop_id';
		else if ($group=="state") return 'state';
		else return "0";
	}
	
	function clean_xls($text)
	{
		$text = trim($text);
		$text = MiscFunctions::stripInvalid($text);
		$cur_encoding = mb_detect_encoding($text) ; 
		if($cur_encoding != "UTF-8" && mb_check_encoding($text,"UTF-8")) 
			$text= utf8_encode($text); 
		//$text =  str_replace("-","*",$text);
		$text = str_replace('"',"\"", $text);
		$text = str_replace("“","\"", $text);
		$text = str_replace("”","\"", $text);
		$text = str_replace("{","(", $text);
		$text = str_replace("}",")", $text);
		$text = str_replace("’","'", $text);
		$text = str_replace("‘","'", $text);
		$text = str_replace("…","...", $text);
		$text = str_replace("â","", $text);
		$text = str_replace("–","-", $text);
		$text = str_replace("/","-", $text);
		$text = str_replace(",","-", $text);
		
		$text = str_replace("*","-", $text);
		$text = preg_replace('/[^\x0A\x20-\x7E]/','',$text);
	   // $text = str_replace("&","&amp;",$text); 
		//$text = htmlspecialchars($text);
		$text = str_replace("     ","", $text);
		$text = str_replace("\t","", $text);
		
		//$text = preg_replace("/()[^A-Za-z0-9]\s\n.,*#@:/u", "",$text);
		//Next replace unify all new-lines into unix LF:
		$text = str_replace("\r","", $text);
		$text = str_replace("\n","", $text);
		//$text = str_replace("\n\n","\n", $text);
		//$description = preg_replace("/()[^A-Za-z0-9]\s\n.,*#@:/u", "",$description);	
	//	$text = str_replace(">&#10;<",">\n<", $xml); 
	 //   $text = str_ireplace($breaks, "&#10;", $contract);
	 $text = utf8_encode($text);
		return $text;
	}
	
	function validate_email ($address) {
		$regex1 = '/^[_a-z0-9-][^()<>@,;:\"[] ]*@([a-z0-9-]+.)+[a-z]{2,4}$/i'; 
		$regex2 = '/^([a-zA-Z0-9_-]).+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-]+)+/'; 
	   // return (preg_match('/^[-!#$%&\'*+\\.0-9=?A-Z^_`a-z{|}~]+/'. '@'. '/[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\./' . '/[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$/', $address));
		return (preg_match($regex2, $address));
	}
	
	function php_for_array($array){
		if(is_array($array)){
			$string .= "array(\n";
			foreach($array as $k=>$v){
				if(is_array($v))$string .= $sep.'"'.$k.'"	=>	'.php_for_array($v);
				else $string .= $sep.'"'.$k.'"	=>	"'.$v.'"';
				$sep = ",\n";
			}
			$string .= "\n)";
		}
		return $string;
	}
	
	// Rebuilds and echoes out your current $_GET array.
	// Pass a key name to exclude it from the function (especially useful when you want to update one of the variables)
	
	
	function get_age($birthday){
		if (!$birthday) return "";
		if (strpos($birthday,"/"))
			$birthday = strtotime($birthday);
		$birthday = date("Y-m-d", $birthday);
		list($year, $month, $day) = explode("-", $birthday);
		$year_diff = date("Y") - $year;
		$month_diff = date("m") - $month;
		$day_diff = date("d") - $day;
		if($year_diff<1)
			return "";
		if($month_diff < 0)$year_diff--;
		elseif(($month_diff==0)&&($day_diff < 0))$year_diff--;
		return $year_diff;
	}
	
	function get_age2($birthday){
		list( $month, $day, $year) = explode("/", $birthday);
		$year_diff = date("Y") - $year;
		$month_diff = date("m") - $month;
		$day_diff = date("d") - $day;
		if($year_diff<1)
			return "";
		if($month_diff < 0)$year_diff--;
		elseif(($month_diff==0)&&($day_diff < 0))$year_diff--;
		return $year_diff;
	}
	
	function show_input($type, $answer, $options=false){
		switch( $type ){
					case 'text':
						echo '<input name="value" type="text" class="input" id="value" style="width:400px;" value="'.Sanitize::sanitize_html_string($answer).'" maxlength="150">';
						break;
					case 'integer':
						echo '<input name="value" type="text" class="input" id="value" style="width:400px;" value="'.Sanitize::sanitize_html_string($answer).'" maxlength="150">';
						break;	
					case 'boolean':
						echo '<label><input type="radio" name="value" id="value" value="Yes" '.($answer=='Yes'?'checked':'').' >'._("Yes").'  </label><label><input type="radio" name="value" id="value" value="No" '.($answer=='No'?'checked':'').' >'._("No").'</label>';
						break;
					case 'select':
						$options = MiscFunctions::parse_options($options);
						echo '<select class="input" name="value" id="value">
						<option value="">'._("Please Choose").'</option>';
						echo select_list_gen($options, $answer);
						echo '</select>';
						break;
					case 'timestamp';
						echo '<input name="value" type="text" class="DatePicker" id="value" value="'.$answer.'">';
						break;
					case 'age';
						echo '<input name="value" type="text" class="DatePicker" id="value" value="'.$answer.'">';
						break;	
				}//end switch	
	}
	
	function show_input_jq($type, $answer, $options=false){
		switch( $type ){
					case 'text':
						echo '<input name="value" type="text" class="input" id="value" style="width:400px;" value="'.Sanitize::sanitize_html_string($answer).'" maxlength="150">';
						break;
					case 'integer':
						echo '<input name="value" type="text" class="input" id="value" style="width:400px;" value="'.Sanitize::sanitize_html_string($answer).'" maxlength="150">';
						break;	
					case 'boolean':
						echo '<label><input type="radio" name="value" id="value" value="Yes" '.($answer=='Yes'?'checked':'').' >'._("Yes").'  </label><label><input type="radio" name="value" id="value" value="No" '.($answer=='No'?'checked':'').' >'._("No").'</label>';
						break;
					case 'select':
						$options = MiscFunctions::parse_options($options);
						echo '<select class="input" name="value" id="value">
						<option value="">'._("Please Choose").'</option>';
						echo select_list_gen($options, $answer);
						echo '</select>';
						break;
					case 'timestamp';
						$answer = localize_datepicker(strtotime($answer));
						echo '<input name="value" type="text" class="datepicker" id="datepicker" value="'.$answer.'">';
						break;
					case 'age';
						$answer = localize_datepicker(strtotime($answer));
						echo '<input name="value" type="text" class="datepicker" id="datepicker" value="'.$answer.'">';
						break;	
				}//end switch	
	}
	
	function show_options($type, $answer, $options=false){
		switch( $type ){
					case 'integer':
						echo '<input name="value" type="text" class="input" id="value" style="width:400px;" value="'.Sanitize::sanitize_html_string($answer).'" maxlength="150">';
						break;	
					case 'boolean':
						echo '<label><input type="radio" name="value" id="value" value="Yes" '.($answer=='Yes'?'checked':'').' >'._("Yes").'</label><label><input type="radio" name="value" id="value" value="No" '.($answer=='No'?'checked':'').' >'._("No").'</label>';
						break;
					case 'select':
						$options = MiscFunctions::parse_options($options);
						$answers = MiscFunctions::parse_options($answer);
						echo '<select class="input" name="values[]" size="10" multiple id="values[]">';
					
						if($options)foreach($options as $option){
					?>
										<option value="<?=$option?>" <?=$answers[$option]?'selected':''?>><?=$option?></option>
					<?
						}//end foreach($options)
					
						echo '</select>';
						break;
					case 'age';
						echo '<input name="value" type="text" class="input" id="value" style="width:400px;" value="'.Sanitize::sanitize_html_string($answer).'" maxlength="150"> years';
						break;
					case 'timestamp';
						echo '<input name="value" type="text" class="DatePicker" id="value" value="'.$answer.'">';
						break;
				}//end switch	
	}
	
	function array_strip_slashes($array){
		if($array && is_array($array)){
			foreach($array as $k=>$v){
				if(!is_array($v))$array[$k] = stripslashes($v);
				else $array[$k] = MiscFunctions::array_strip_slashes($v);
			}
		}
		return $array;
	}
	
	
	
	function parse($string){	
			if (!trim($string))
				return array();	
			$array = explode('|',$string);
			//if(($array)and is_array($array)) foreach ($array as $k=>$v)
				//$new_array.=trim($v).",";
			return $array;		
		}
	function un_parse($array){
			if(($array)and is_array($array)) foreach ($array as $k=>$v)
				$new_array.=trim($v)."|";
			return $new_array;		
		}
	
	//check to see if a string contains only alphanumeric characters
	function check_alphanumeric($string, $allowcaps = true){
	  $allowed = 'abcdefghijklmnopqrstuvwxyz0123456789';
	  if($allowcaps) $allowed .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	  if(strspn($string, $allowed) < strlen($string)) return false;
	  else return true;
	}
	
	// Formats input text for use in things such as blogs
	// This should continually be added to for advancement
	function text_format($text, $html = false){
		if(!$html)$text = sanitize_html_string($text);
		$text = str_replace("\n", '<br>', $text);
		return $text;
	}
	
	function text_trim($text, $max = 20){
		$text = explode(' ', $text);
		if($text){
			if(count($text) > $max){
				$text = array_slice($text, 0, $max);
				array_push($text, '...');
			}
			$text = implode(' ', $text);
		}
		return $text;
	}
	
	//quick functions so I don't have to keep manually typing <pre> tags when I echo something or print_r something
	function echopre($str){
	  echo '<pre>'.$str."</pre>";
	}
	
	function printrpre($val){
	  echo '<pre>';
	  print_r($val);
	  echo '</pre>';
	}
	
	// Returns the % of how dark a color is
	function hex_tone($hex){
		$hex = strtolower($hex);
		$values = array('0'=>0,'1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5,'6'=>6,'7'=>7,'8'=>8,'9'=>9,'a'=>'10','b'=>'11','c'=>'12','d'=>'13','e'=>'14','f'=>'15');
		$hex = str_split($hex);
		$red = $values[$hex[0]]*16+$values[$hex[1]];
		$green = $values[$hex[2]]*16+$values[$hex[3]];
		$blue = $values[$hex[4]]*16+$values[$hex[5]];
		
		$perc = ceil((($red+$green+$blue) / 768) * 100);
		return $perc;
	}
	
	
	function censor($str){
		$badwords = array('fuck', 'shit', 'bitch', 'cunt');
		foreach($badwords as $v)
			$str = str_ireplace($v, '####', $str);
		return $str;
	}
	
	//only seems to work with Mootools.  See one above as part of class for jquery  
	function image_switch($image, $field, $maxwidth=400, $maxheight=400){
		$html = '';
		$field = Sanitize::sanitize_html_string($field);
		if( $image && file_exists($image) )
			$i = true;
		if( $i )
			$html .= "<div id='$field-cur'><img style='max-width:".$maxwidth."px; max-height:".$maxheight."px;' src='/$image' /><br><br><a class='subalert' href='#' onClick=\"$('$field-cur').style.display='none';$('$field-new').style.display='block';$('$field').value='';return false;\">Change</a></div>";
		$html .= "<div id='$field-new' style='display:" . ($i?'none':'block') . "'><input type='file' name='$field' id='$field-file' />";
		if( $i )
			$html .= "<br><br><a class='subalert' href='#' onClick=\"$('$field-new').style.display='none';$('$field-cur').style.display='block';$('$field').value=$('$field').defaultValue;return false;\">Cancel</a>";
		$html .= "</div>";
		$html .= "<input type='hidden' name='$field' id='$field' value='$image' />";
		return $html;
	}
	
	function file_switch($image, $field){
		$html = '';
		$field = Sanitize::sanitize_html_string($field);
		if( $image && file_exists($image) )
			$i = true;
		if( $i )
			$html .= "<div id='$field-cur'><a href='/$image' target='_blank'><img src='/images/icons/paper_content_48.png' /></a><br><br><a class='subalert' href='#' onClick=\"$('$field-cur').style.display='none';$('$field-new').style.display='block';$('$field').value='';return false;\">Change</a></div>";
		$html .= "<div id='$field-new' style='display:" . ($i?'none':'block') . "'><input type='file' name='$field' id='$field-file' />";
		if( $i )
			$html .= "<br><br><a class='subalert' href='#' onClick=\"$('$field-new').style.display='none';$('$field-cur').style.display='block';$('$field').value=$('$field').defaultValue;return false;\">Cancel</a>";
		$html .= "</div>";
		$html .= "<input type='hidden' name='$field' id='$field' value='$image' />";
		return $html;
	}
	
	function month_get(){
		$l = array(
			"1" => "January",
			"2" => "February",
			"3" => "March",
			"4" => "April",
			"5" => "May",
			"6" => "June",
			"7" => "July",
			"8" => "August",
			"9" => "September",
			"10" => "October",
			"11" => "November",
			"12" => "December"
		);
		return $l;
	}
	
	function month_gen_list_0($selected=false){
	  $dates = month_get_0();
	  if($dates)foreach($dates as $k=>$v){
		$result .= "<option value='$k'";
		if($selected == $k) $result .= " selected='selected'";
		$result .= ">$v</option>\n";
	  }
	  return $result;
	}
	
	function month_get_0(){
		$l = array(
			"01" => "January",
			"02" => "February",
			"03" => "March",
			"04" => "April",
			"05" => "May",
			"06" => "June",
			"07" => "July",
			"08" => "August",
			"09" => "September",
			"10" => "October",
			"11" => "November",
			"12" => "December"
		);
		return $l;
	}
	
	function month_gen_list($selected=false){
	  $dates = month_get();
	  if($dates)foreach($dates as $k=>$v){
		$result .= "<option value='$k'";
		if($selected == $k) $result .= " selected";
		$result .= ">$v</option>\n";
	  }
	  return $result;
	}
	
	function year_get(){
		$l = array();
		$year = date("Y", time()+(60*60*24*30));
		$i=0;
		while ($i<5)
		{
			$l[$year] = $year;
			$year = $year-1;
			$i=$i+1;
		}
		return $l;
	}
	
	function year_gen_list($selected=false){
	  $dates = year_get();
	  if($dates)foreach($dates as $k=>$v){
		$result .= "<option value='$k'";
		if($selected == $k) $result .= " selected";
		$result .= ">$v</option>\n";
	  }
	  return $result;
	}
	
	function month_year_get(){
	$l = array();
		$date = time()+(60*60*24*120);
		$i=0;
		while ($i<15)
		{
			$month_year = date("m/Y", $date);
			$month_year_long = date("F Y", $date);
			$l[$month_year] = $month_year_long;
			$date = strtotime(date("F d, Y", $date))-(60*60*24*20);
			echo date("m 1, Y", $date);
			$i=$i+1;
		}
		return $l;
	}
	
	function month_year_gen_list($selected=false){
	  $dates = month_year_get();
	  if($dates)foreach($dates as $k=>$v){
		$result .= "<option value='$k'";
		if($selected == $k) $result .= " selected";
		$result .= ">$v</option>\n";
	  }
	  return $result;
	}
	
	function random_readable_pwd($length=10){
	
		// the wordlist from which the password gets generated 
		// (change them as you like)
		$words = 'AbbyMallard,AbigailGabble,AbisMal,Abu,Adella,TheAgent,AgentWendyPleakley,Akela,AltheAlligator,Aladar,Aladdin,AlamedaSlim,AlanaDale,Alana,Alcmene,Alice,AmeliaGabble,AmosSlade,Amphitryon,AnastasiaTremaine,Anda,Andrina,Angelique,AngusMacBadger';
	
		// Split by ",":
		$words = explode(',', $words);
		if (count($words) == 0){ die('Wordlist is empty!'); }
	
		// Add words while password is smaller than the given length
		$pwd = '';
		while (strlen($pwd) < $length){
			$r = mt_rand(0, count($words)-1);
			$pwd .= $words[$r];
		}
	
		$num = mt_rand(1, 99);
		 if ($length > 2){
			$pwd = substr($pwd,0,$length-strlen($num)).$num;
		} else { 
			$pwd = substr($pwd, 0, $length);
		}
	
	   $pass_length = strlen($pwd);
	   $random_position = rand(0,$pass_length);
	
	//   $syms = "!#%^*()-+";
	//   $int = rand(0,8);
	//   $rand_char = $syms[$int];
	
	  // $pwd = substr_replace($pwd, $rand_char, $random_position, 0);
	
		return $pwd;
	}
	
	function getRemoteFileSize ( $url )
	{
		if ( intval(phpversion()) < 5 )
			die ( 'PHP5 Required' );
		
		$headers = get_headers ( $url, 1 );
		return $headers['Content-Length'];
	} 
	
	function stripInvalid($value)
	{
		$ret = "";
		$current;
		if (empty($value)) 
		{
			return $ret;
		}
	
		$length = strlen($value);
		for ($i=0; $i < $length; $i++)
		{
			$current = ord($value{$i});
			if (($current == 0x9) ||
				($current == 0xA) ||
				($current == 0xD) ||
				(($current >= 0x20) && ($current <= 0xD7FF)) ||
				(($current >= 0xE000) && ($current <= 0xFFFD)) ||
				(($current >= 0x10000) && ($current <= 0x10FFFF)))
			{
				$ret .= chr($current);
			}
			else
			{
				$ret .= " ";
			}
		}
		
		return $ret;
	}
	
	function clean_xml($text)
	{
		$text = stripInvalid($text);
		$cur_encoding = mb_detect_encoding($text) ; 
		if($cur_encoding != "UTF-8" && mb_check_encoding($text,"UTF-8")) 
			$text= utf8_encode($text); 
		//$text =  str_replace("-","*",$text);
		$text = preg_replace('/[^\x0A\x20-\x7E]/','',$text);
		$text = str_replace("“","\"", $text);
		$text = str_replace("”","\"", $text);
		$text = str_replace("{","(", $text);
		$text = str_replace("}",")", $text);
		$text = str_replace("’","'", $text);
		$text = str_replace("‘","'", $text);
		$text = str_replace("…","...", $text);
		$text = str_replace("â","", $text);
		$text = str_replace("-","-", $text);
		$text = str_replace("–","-", $text);
		$text = str_replace("*","-", $text);
	   // $text = str_replace("&","&amp;",$text); 
		//$text = htmlspecialchars($text);
		$text = str_replace("     ","", $text);
		$text = str_replace("\t","", $text);
		
		//$text = preg_replace("/()[^A-Za-z0-9]\s\n.,*#@:/u", "",$text);
		//Next replace unify all new-lines into unix LF:
		$text = str_replace("\r","\n", $text);
		$text = str_replace("\n\n\n","\n", $text);
		//$text = str_replace("\n\n","\n", $text);
		//$description = preg_replace("/()[^A-Za-z0-9]\s\n.,*#@:/u", "",$description);	
	//	$text = str_replace(">&#10;<",">\n<", $xml); 
	 //   $text = str_ireplace($breaks, "&#10;", $contract);
	 $text = utf8_encode($text);
		return $text;
	}
	
	/// created this one for the shopquestions app feed because special characters were being filtered out.
	function clean_xml2($text)
	{
		$text = stripInvalid($text);
		$cur_encoding = mb_detect_encoding($text) ; 
		if($cur_encoding != "UTF-8" && mb_check_encoding($text,"UTF-8")) 
			$text= utf8_encode($text); 
		//$text =  str_replace("-","*",$text);
		
		$text = str_replace("“","\"", $text);
		$text = str_replace("”","\"", $text);
		$text = str_replace("{","(", $text);
		$text = str_replace("}",")", $text);
		$text = str_replace("’","'", $text);
		$text = str_replace("‘","'", $text);
		$text = str_replace("…","...", $text);
		//$text = str_replace("â","a", $text);
		$text = str_replace("-","-", $text);
		$text = str_replace("–","-", $text);
		//$text = preg_replace('/[^\x0A\x20-\x7E]/','',$text);
		$text = str_replace("     ","", $text);
		$text = str_replace("\t","", $text);
		
		$text = str_replace("\r","\n", $text);
		$text = str_replace("\n\n\n","\n", $text);
	// $text = utf8_encode($text);
		return $text;
	}
	
	
	function minutes_list()
	{
	 
	  for($x=0;$x<=59;$x++)
		  $minutes[strlen($x)<2 ? '0' . $x : $x] = strlen($x)<2 ? '0' . $x : $x;
		return $minutes;  
	}
	
	function hours_list()
	{
		for($x=0;$x<=23;$x++)
			$hours[strlen($x)<2 ? '0' . $x : $x] = $x<12?($x==0?12:$x).' am':($x==12?12:($x-12)).' pm';
		return $hours;	
	}
	
	function localize_timedate($time, $show_day = true)
	{
		if (!$time) return false;
		if (!is_numeric($time))
			$time = strtotime($time);
		if (!$time) return false;
		
		if ($_SESSION[lang] == 'en_US' or $_SESSION[lang] == '')
		{
			if ($show_day)
				$string = strftime("%A %B %e %Y %l:%M",$time).(intval(strftime("%H",$time)) < 12 ? 'AM' : 'PM');
			else
				$string = strftime("%B %e %Y %l:%M",$time).(intval(strftime("%H",$time)) < 12 ? 'AM' : 'PM');
			
		}else
		{
			if ($show_day)
				$string = strftime("%A %e %B %Y %l:%M",$time).(intval(strftime("%H",$time)) < 12 ? 'AM' : 'PM');
			else
				$string = strftime("%e %B %Y %l:%M",$time).(intval(strftime("%H",$time)) < 12 ? 'AM' : 'PM');
		}
		return $string;
	}
	
	function localize_time($time)
	{
		if (!$time) return false;
		if (!is_numeric($time))
			$time = strtotime($time);
		if (!$time) return false;
		
		if ($_SESSION[lang] == 'en_US' or $_SESSION[lang] == '')
			$string = strftime("%l:%M",$time).(intval(strftime("%H",$time)) < 12 ? 'AM' : 'PM');
		else
			$string = strftime("%l:%M",$time).(intval(strftime("%H",$time)) < 12 ? 'AM' : 'PM');

		return $string;
	}
	
	
	function localize_date($time, $short = true)
	{
			if ($time==0) return false;
		
		if (!is_numeric($time))
			$time = strtotime($time);
		
		if ($_SESSION[lang] == 'en_US' or $_SESSION[lang] == '')
		{
			if ($short)
				$string = strftime("%b %e, %Y",$time);
			else
				$string = strftime("%A %B %e, %Y",$time);
		}else
		{
			if ($short)
				$string = strftime("%e %b %Y",$time);
			else
				$string = strftime("%A %e %B %Y",$time);
		}
		
			
		return $string;
	}
	
	
	function localize_admin_td($time)
	{
		//time stamp passed in.  Good for viewing things like last log in.
		if ($time==0) return false;
		if (!is_numeric($time))
			$time = strtotime($time);
		$string = strftime("%e %b %y %l:%M",$time).(intval(strftime("%H",$time)) < 12 ? 'am' : 'pm').strftime(" %Z",$time);
		
		return $string;
	}
	
	function localize_mdy($time)
	{
		if ($time==0) return false;
		
		if (!is_numeric($time))
			$time = strtotime($time);
		
		if ($_SESSION[lang] == 'en_US' or $_SESSION[lang] == '')
		{
			$format = "%m/%d/%y";
			
		}else if ($_SESSION[lang] == 'fr_CA')
		{
			$format = '%Y-%m-%d';
		}
		else	
		{
			$format = "%d/%m/%y";
		}
	
		$string = strftime($format,$time);
			
		return $string;
	}
	function localize_strtotime($time)
	{
		//works with jquery datepicker.  Do not use anywhere else
		if ($_SESSION[lang] == 'en_US' or $_SESSION[lang] == '')
		{
			//$format = '%m/%d/%y';
			$timearray=explode("/",$time);
			$month = $timearray[0];
			$day = $timearray[1];
			$year = $timearray[2];
			//print_r($timearray);
			
		}else if ($_SESSION[lang] == 'fr_CA')
		{
			//$format = '%Y-%m-%d';
			$timearray=explode("-",$time);
			$year = $timearray[0];
			$month = $timearray[1];
			$day = $timearray[2];
		}
		else if ($_SESSION[lang] == 'lv_LV')
		{
			//$format = '%Y-%m-%d';
			$timearray=explode(".",$time);
			$year = $timearray[0];
			$month = $timearray[1];
			$day = $timearray[2];
		} else
		{
			//$format = '%d/%m/%y';
			$timearray=explode("/",$time);
			$day = $timearray[0];
			$month = $timearray[1];
			$year = $timearray[2];
		}
		
		$date = $year.'-'.$month.'-'.$day;
		
		$unixtime =  strtotime($date);
		
		return $unixtime;
	}
	function localize_datepicker($time)
	{
		
		if (!$time) return false;
		
		//works with jquery datepicker.  Do not use anywhere else
		if ($_SESSION[lang] == 'en_US' or $_SESSION[lang] == '')
		{
			$format = 'm/d/Y';
			
		}else if ($_SESSION[lang] == 'fr_CA')
		{
			$format = 'Y-m-d';
		}else if ($_SESSION[lang] == 'lv_LV')
		{
			$format = 'd.m.Y';
		}
		else	
		{
			$format = 'd/m/Y';
		}
		
		
		return date($format,$time);
	}
	function seconds_to_hours($seconds)
	{
		$hours = floor($seconds/3600);
				$minutes = floor(($seconds-($hours*3600))/60);			
				$seconds = $seconds-($hours*3600)-($minutes*60);
				$answer="";
				if ($hours)
					$answer .= $hours." hours and ";
				if ($hours OR $minutes)
					$answer .= $minutes." minutes ";	
				if(!isset($answer)) $answer = "less than a minute ";
				//$answer .= $seconds ." seconds"; 	
		return $answer;		
	}
	
	function distance($lat1, $lon1, $lat2, $lon2, $unit) {
		 
		  $theta = $lon1 - $lon2;
		  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		  $dist = acos($dist);
		  $dist = rad2deg($dist);
		  $miles = $dist * 60 * 1.1515;
		  $unit = strtoupper($unit);
		 
		  if ($unit == "K") {
			return ($miles * 1.609344);
		  } else if ($unit == "N") {
			  return ($miles * 0.8684);
			} else {
				return $miles;
			  }
	}
	
	function decimal_places($value)
	{
		
		if (!is_numeric($value))
		{
			// throw new Exception('numberOfDecimals: ' . $value . ' is not a number!');
			return false;
		} else if ((int)$value == $value)
		{
			return 0;
		}
	
		return strlen($value) - strrpos($value, '.') - 1;
	}

}

	function buildGET($fields)
	{	if(!$fields) return false;
		foreach($fields as $k=>$v){
				$result.=$sep.($k.'='.urlencode($v));
				$sep = '&';
		}
		return $result;
	}
//Generate a <select> list and select whichever value is passed
function select_list_gen($array, $selected = false){
  if($array && is_array($array)){
    $html = '';
    foreach($array as $k=>$v){
      $html .= '<option value="'.htmlentities($k).'"';
      if($k == $selected) $html .= " selected='selected'";
      $html .= ">".htmlentities($v)."</option>\n";
    }
  }
  return $html;
}

function select_list_gen_enum($table_name, $column_name, $selected = false){
	$db = getDB();
	 $html = '';
	 $sql = 'SHOW COLUMNS FROM '.$table_name.' WHERE field="'.$column_name.'"';
    $row = $db->query($sql);
	
    foreach(explode("','",substr($row[0]['Type'],6,-2)) as $option) {
		 $html .= '<option value="'.$option.'"';
      	 if($option == $selected) $html .= " selected";
     	 $html .= ">" . htmlentities($option) . ".</option>\n";
	  
       
        }
  return $html;
}


function select_list_gen_order($array, $order, $selected = false){
	if($array && is_array($array) && $order && is_array($order)){
		 $html = '';
		asort($order);
		foreach($order as $k=>$v){
			$v = trim($array[$k]);
			if( $v  ){ 
				$html .= "<option value='".$k."' ";
				if ($selected==$k) $html .= "selected";
				$html .= ">".htmlentities($v)." </option>";
					
			}
		}
	}
  
  return $html;
}

function select_list($list=array(), $name='', $size=1, $request = NULL, $multi=false, $use_values_as_keys=false)
{
    $select_name = ($multi) ? $name.'[]' : $name;
    $multi = ($multi) ? ' multiple="multiple"' : '';
    
    $xml = '<select name="'.$select_name.'" size="'.$size.'"'.$multi.'>';
    if ($list) foreach($list as $value=>$label)
    {
        if ($use_values_as_keys) $value = $label;
        $is_selected = '';
        if (is_array($request[$name]))
        {
            if (in_array($value, $request[$name])) $is_selected = ' selected="selected"';
        }
        else
        {
            if ($value == $request[$name]) $is_selected = ' selected="selected"';
        }
        $xml .= '<option value="'.$value.'"'.$is_selected.'>'.htmlentities($label).'</option>';
    }
    $xml .= '</select>';
    
    return $xml;
}

function altSwitch($x){
		if( $x )
			return false;
		else
			return true;
	}
	
function format_address($address1=false, $address2=false, $municipality=false, $city=false, $state=false, $state_other=false, $zip=false, $country="US")
{
	if ($country=="US" OR $country=="CA"){
		$html = $address1;
		if ($address2) $html .= "<br>".$address2;
       	$html .="<br>".$city . ', ' . $state . ' ' . $zip;
	}else if ($country=="CL"){
		$html = $address1;
		if ($address2) $html .= "<br>".$address2;
		if ($zip) $html .= "<br>".$zip;
		if ($municipality) $html .= "<br>".$municipality;
       if ($city) $html .= "<br>".$city;
	   $html .= "<br>".$country;
	} else
	{
		$html = $address1;
		if ($address2) $html .= "<br>".$address2;
       	$html .="<br>".$city . ', ' . $state_other . ' ' . $zip;
		if ($country) $html .= "<br>".$country;
	}
    return trim($html);
}

function format_short_address($address1=false, $municipality=false, $city=false, $country="US")
{
	if ($country=="US" OR $country=="CA" OR $country==""){
		$html = $address1.' '.$city;
	}else if ($country=="CL"){
		$html = $address1.' '.$city;
		if ($municipality) $html .= " ".$municipality;
       if ($city) $html .= " ".$city;
	} else
	{
		$html = $address1;
		if ($municipality) $html .= " ".$municipality;
       if ($city) $html .= " ".$city;
	}
    return trim($html);
}
function states_get(){
  $states = array(
    "AK"	=>	"Alaska",
    "AL"	=>	"Alabama",
    "AR"	=>	"Arkansas",
    "AZ"	=>	"Arizona",
    "CA"	=>	"California",
    "CO"	=>	"Colorado",
    "CT"	=>	"Connecticut",
    "DC"	=>	"District of Columbia",
    "DE"	=>	"Delaware",
    "FL"	=>	"Florida",
    "GA"	=>	"Georgia",
    "HI"	=>	"Hawaii",
    "IA"	=>	"Iowa",
    "ID"	=>	"Idaho",
    "IL"	=>	"Illinois",
    "IN"	=>	"Indiana",
    "KS"	=>	"Kansas",
    "KY"	=>	"Kentucky",
    "LA"	=>	"Louisiana",
    "MA"	=>	"Massachusetts",
    "MD"	=>	"Maryland",
    "ME"	=>	"Maine",
    "MI"	=>	"Michigan",
    "MN"	=>	"Minnesota",
    "MO"	=>	"Missouri",
    "MS"	=>	"Mississippi",
    "MT"	=>	"Montana",
    "NC"	=>	"North Carolina",
    "ND"	=>	"North Dakota",
    "NE"	=>	"Nebraska",
    "NH"	=>	"New Hampshire",
    "NJ"	=>	"New Jersey",
    "NM"	=>	"New Mexico",
    "NV"	=>	"Nevada",
    "NY"	=>	"New York",
    "OH"	=>	"Ohio",
    "OK"	=>	"Oklahoma",
    "OR"	=>	"Oregon",
    "PA"	=>	"Pennsylvania",
	"PR"	=>	"Puerto Rico",
    "RI"	=>	"Rhode Island",
    "SC"	=>	"South Carolina",
    "SD"	=>	"South Dakota",
    "TN"	=>	"Tennessee",
    "TX"	=>	"Texas",
    "UT"	=>	"Utah",
    "VA"	=>	"Virginia",
	"VI"	=>	"Virgin Islands",
    "VT"	=>	"Vermont",
    "WA"	=>	"Washington",
    "WV"	=>	"West Virginia",
    "WI"	=>	"Wisconsin",
    "WY"	=>	"Wyoming"
  );
  /*
  $query = "SELECT * FROM states";
  unset($states);
  $result = dbQuery($query);
  if($result)foreach($result as $k=>$v){
    $states[$v['id']] = $v['name'];
  }
  */
  return $states;
}
function provinces_get(){
	$provinces = array(
		"AB"	=>	"Alberta",
		"BC"	=>	"British Columbia",
		"MB"	=> 	"Manitoba",
		"NB"	=>	"New Brunswick",
		"NL"	=>  "Newfoundland and Labrador",
		"NT"	=>  "Northwest Territories",
		"NS"	=>	"Nova Scotia",
		"NU"	=> 	"Nunavut",
		"ON"	=> 	"Ontario",
		"PE"	=> 	"Prince Edward Island",
		"QC"	=> 	"Quebec",
		"SK"	=> 	"Saskatchewan",
		"YT"	=> 	"Yukon Territory"
	);
	return $provinces;
}
function states_gen_list($selected=false){
  $states = states_get();
  $provinces = provinces_get();
  $result .= "<optgroup label='United States'>";
  if($states)foreach($states as $k=>$v){
    $result .= "<option value='$k'";
    if($selected == $k) $result .= " selected";
    $result .= ">$v</option>\n";
  }
  $result .= "</optgroup>";
  $result .= "<optgroup label='Canada'>";
  if($provinces)foreach($provinces as $k=>$v){
    $result .= "<option value='$k'";
    if($selected == $k) $result .= " selected";
    $result .= ">$v</option>\n";
  }
  $result .= "</optgroup>";
  return $result;
}

function countries_get(){
	$l = array(
		"US" => "United States",
		"CA" => "Canada",
		"BR" => "Brazil",
		"AT" => "Austria",
		"UK" => "United Kingdom",
		"NL" => "Netherlands",
		"SE" => "Sweden",
		"DE" => "Germany",
		"NZ" => "New Zealand",
		"MX" => "Mexico",
		"AD" => "Andorra",
		"AE" => "United Arab Emirates",
		"AF" => "Afghanistan",
		"AG" => "Antigua and Barbuda",
		"AI" => "Anguilla",
		"AL" => "Albania",
		"AM" => "Armenia",
		"AN" => "Netherlands Antilles",
		"AO" => "Angola",
		"AQ" => "Antarctica",
		"AR" => "Argentina",
		"AS" => "American Samoa",
		"AU" => "Australia",
		"AW" => "Aruba",
		"AZ" => "Azerbaijan",
		"BA" => "Bosnia and Herzegovina",
		"BB" => "Barbados",
		"BD" => "Bangladesh",
		"BE" => "Belgium",
		"BF" => "Burkina Faso",
		"BG" => "Bulgaria",
		"BH" => "Bahrain",
		"BI" => "Burundi",
		"BJ" => "Benin",
		"BM" => "Bermuda",
		"BN" => "Brunei Darussalam",
		"BO" => "Bolivia",
		"BR" => "Brazil",
		"BS" => "Bahamas",
		"BT" => "Bhutan",
		"BV" => "Bouvet Island",
		"BW" => "Botswana",
		"BY" => "Belarus",
		"BZ" => "Belize",
		"CC" => "Cocos (Keeling) Islands",
		"CF" => "Central African Republic",
		"CG" => "Congo",
		"CH" => "Switzerland",
		"CI" => "Cote D'Ivoire (Ivory Coast)",
		"CK" => "Cook Islands",
		"CL" => "Chile",
		"CM" => "Cameroon",
		"CN" => "China",
		"CO" => "Colombia",
		"CR" => "Costa Rica",
		"CS" => "Czechoslovakia (former)",
		"CU" => "Cuba",
		"CV" => "Cape Verde",
		"CX" => "Christmas Island",
		"CY" => "Cyprus",
		"CZ" => "Czech Republic",
		"DJ" => "Djibouti",
		"DK" => "Denmark",
		"DM" => "Dominica",
		"DO" => "Dominican Republic",
		"DZ" => "Algeria",
		"EC" => "Ecuador",
		"EE" => "Estonia",
		"EG" => "Egypt",
		"EH" => "Western Sahara",
		"ER" => "Eritrea",
		"ES" => "Spain",
		"ET" => "Ethiopia",
		"FI" => "Finland",
		"FJ" => "Fiji",
		"FK" => "Falkland Islands (Malvinas)",
		"FM" => "Micronesia",
		"FO" => "Faroe Islands",
		"FR" => "France",
		"FX" => "France, Metropolitan",
		"GA" => "Gabon",
		"GD" => "Grenada",
		"GE" => "Georgia",
		"GF" => "French Guiana",
		"GH" => "Ghana",
		"GI" => "Gibraltar",
		"GL" => "Greenland",
		"GM" => "Gambia",
		"GN" => "Guinea",
		"GP" => "Guadeloupe",
		"GQ" => "Equatorial Guinea",
		"GR" => "Greece",
		"GS" => "S. Georgia and S. Sandwich Isls.",
		"GT" => "Guatemala",
		"GU" => "Guam",
		"GW" => "Guinea-Bissau",
		"GY" => "Guyana",
		"HK" => "Hong Kong",
		"HM" => "Heard and McDonald Islands",
		"HN" => "Honduras",
		"HR" => "Croatia (Hrvatska)",
		"HT" => "Haiti",
		"HU" => "Hungary",
		"ID" => "Indonesia",
		"IE" => "Ireland",
		"IL" => "Israel",
		"IN" => "India",
		"IO" => "British Indian Ocean Territory",
		"IQ" => "Iraq",
		"IR" => "Iran",
		"IS" => "Iceland",
		"IT" => "Italy",
		"JM" => "Jamaica",
		"JO" => "Jordan",
		"JP" => "Japan",
		"KE" => "Kenya",
		"KG" => "Kyrgyzstan",
		"KH" => "Cambodia",
		"KI" => "Kiribati",
		"KM" => "Comoros",
		"KN" => "Saint Kitts and Nevis",
		"KP" => "Korea (North)",
		"KR" => "Korea (South)",
		"KW" => "Kuwait",
		"KY" => "Cayman Islands",
		"KZ" => "Kazakhstan",
		"LA" => "Laos",
		"LB" => "Lebanon",
		"LC" => "Saint Lucia",
		"LI" => "Liechtenstein",
		"LK" => "Sri Lanka",
		"LR" => "Liberia",
		"LS" => "Lesotho",
		"LT" => "Lithuania",
		"LU" => "Luxembourg",
		"LV" => "Latvia",
		"LY" => "Libya",
		"MA" => "Morocco",
		"MC" => "Monaco",
		"MD" => "Moldova",
		"MG" => "Madagascar",
		"MH" => "Marshall Islands",
		"MK" => "Macedonia",
		"ML" => "Mali",
		"MM" => "Myanmar",
		"MN" => "Mongolia",
		"MO" => "Macau",
		"MP" => "Northern Mariana Islands",
		"MQ" => "Martinique",
		"MR" => "Mauritania",
		"MS" => "Montserrat",
		"MT" => "Malta",
		"MU" => "Mauritius",
		"MV" => "Maldives",
		"MW" => "Malawi",
		"MY" => "Malaysia",
		"MZ" => "Mozambique",
		"NA" => "Namibia",
		"NC" => "New Caledonia",
		"NE" => "Niger",
		"NF" => "Norfolk Island",
		"NG" => "Nigeria",
		"NI" => "Nicaragua",
		"NO" => "Norway",
		"NP" => "Nepal",
		"NR" => "Nauru",
		"NT" => "Neutral Zone",
		"NU" => "Niue",
		"OM" => "Oman",
		"PA" => "Panama",
		"PE" => "Peru",
		"PF" => "French Polynesia",
		"PG" => "Papua New Guinea",
		"PH" => "Philippines",
		"PK" => "Pakistan",
		"PL" => "Poland",
		"PM" => "St. Pierre and Miquelon",
		"PN" => "Pitcairn",
		"PR" => "Puerto Rico",
		"PT" => "Portugal",
		"PW" => "Palau",
		"PY" => "Paraguay",
		"QA" => "Qatar",
		"RE" => "Reunion",
		"RO" => "Romania",
		"RU" => "Russian Federation",
		"RW" => "Rwanda",
		"SA" => "Saudi Arabia",
		"SB" => "Solomon Islands",
		"SC" => "Seychelles",
		"SD" => "Sudan",
		"SG" => "Singapore",
		"SH" => "St. Helena",
		"SI" => "Slovenia",
		"SJ" => "Svalbard and Jan Mayen Islands",
		"SK" => "Slovak Republic",
		"SL" => "Sierra Leone",
		"SM" => "San Marino",
		"SN" => "Senegal",
		"SO" => "Somalia",
		"SR" => "Suriname",
		"ST" => "Sao Tome and Principe",
		"SU" => "USSR (former)",
		"SV" => "El Salvador",
		"SY" => "Syria",
		"SZ" => "Swaziland",
		"TC" => "Turks and Caicos Islands",
		"TD" => "Chad",
		"TF" => "French Southern Territories",
		"TG" => "Togo",
		"TH" => "Thailand",
		"TJ" => "Tajikistan",
		"TK" => "Tokelau",
		"TM" => "Turkmenistan",
		"TN" => "Tunisia",
		"TO" => "Tonga",
		"TP" => "East Timor",
		"TR" => "Turkey",
		"TT" => "Trinidad and Tobago",
		"TV" => "Tuvalu",
		"TW" => "Taiwan",
		"TZ" => "Tanzania",
		"UA" => "Ukraine",
		"UG" => "Uganda",
		"UM" => "US Minor Outlying Islands",
		"UY" => "Uruguay",
		"UZ" => "Uzbekistan",
		"VA" => "Vatican City State (Holy See)",
		"VC" => "Saint Vincent and the Grenadines",
		"VE" => "Venezuela",
		"VG" => "Virgin Islands (British)",
		"VI" => "Virgin Islands (U.S.)",
		"VN" => "Viet Nam",
		"VU" => "Vanuatu",
		"WF" => "Wallis and Futuna Islands",
		"WS" => "Samoa",
		"YE" => "Yemen",
		"YT" => "Mayotte",
		"YU" => "Yugoslavia",
		"ZA" => "South Africa",
		"ZM" => "Zambia",
		"ZR" => "Zaire",
		"ZW" => "Zimbabwe"
	);
	return $l;
}

function countries_gen_list($selected=false){
  $countries = countries_get();
  if($countries)foreach($countries as $k=>$v){
    $result .= "<option value='$k'";
    if($selected == $k) $result .= " selected";
    $result .= ">$v</option>\n";
  }
  return $result;
}
?>