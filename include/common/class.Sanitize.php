<?

class Sanitize{
	public $PARANOID = 1;
	public $SQL = 2;
	public $SYSTEM = 4;
	public $HTML = 8;
	public $INT = 16;
	public $FLOAT = 32;
	public $LDAP = 64;
	public $UTF8 = 128;
	
	// internal function for utf8 decoding
	// thanks to Jamie Pratt for noticing that PHP's function is a little 
	// screwy
	function my_utf8_decode($string)
	{
	return strtr($string, 
	  "???????¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ", 
	  "SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
	}
	
	// paranoid sanitization -- only let the alphanumeric set through
	function sanitize_paranoid_string($string, $min='', $max='')
	{
	  $string = preg_replace("/[^a-zA-Z0-9]/", "", $string);
	  $len = strlen($string);
	  if((($min != '') && ($len < $min)) || (($max != '') && ($len > $max)))
		return FALSE;
	  return $string;
	}
	
	// sanitize a string in prep for passing a single argument to system() (or similar)
	function sanitize_system_string($string, $min='', $max='')
	{
	  $pattern = '/(;|\||`|>|<|&|^|"|'."\n|\r|'".'|{|}|[|]|\)|\()/i'; // no piping, passing possible environment variables ($),
							   // seperate commands, nested execution, file redirection, 
							   // background processing, special commands (backspace, etc.), quotes
							   // newlines, or some other special characters
	  $string = preg_replace($pattern, '', $string);
	  $string = '"'.preg_replace('/\$/', '\\\$', $string).'"'; //make sure this is only interpretted as ONE argument
	  $len = strlen($string);
	  if((($min != '') && ($len < $min)) || (($max != '') && ($len > $max)))
		return FALSE;
	  return $string;
	}
	
	// sanitize a string for SQL input (simple slash out quotes and slashes)
	function sanitize_sql_string($string, $min='', $max='')
	{
	  $pattern[0] = '/(\\\\)/';
	  $pattern[1] = "/\"/";
	  $pattern[2] = "/'/";
	  $replacement[0] = '\\\\\\';
	  $replacement[1] = '\"';
	  $replacement[2] = "\\'";
	  $len = strlen($string);
	  if((($min != '') && ($len < $min)) || (($max != '') && ($len > $max)))
		return FALSE;
	  return preg_replace($pattern, $replacement, $string);
	}
	
	// sanitize a string for SQL input (simple slash out quotes and slashes)
	function sanitize_ldap_string($string, $min='', $max='')
	{
	  $pattern = '/(\)|\(|\||&)/';
	  $len = strlen($string);
	  if((($min != '') && ($len < $min)) || (($max != '') && ($len > $max)))
		return FALSE;
	  return preg_replace($pattern, '', $string);
	}
	
	
	// sanitize a string for HTML (make sure nothing gets interpretted!)
	function sanitize_html_string($string)
	{
		$search = array (
      'â€“'
   );
   $replace = array (
	  '-'
      
   );
   	
	  $str=str_replace($search, $replace, $string);
	  
	  $pattern[0] = '/\&/';
	  $pattern[1] = '/</';
	  $pattern[2] = "/>/";
	  $pattern[4] = '/"/';
	  $pattern[5] = "/'/";
	  $pattern[6] = "/%/";
	  $pattern[7] = '/\(/';
	  $pattern[8] = '/\)/';
	  $pattern[9] = '/\+/';
	  $pattern[10] = '/-/';
   
	  $replacement[0] = '&amp;';
	  $replacement[1] = '&lt;';
	  $replacement[2] = '&gt;';
	  $replacement[4] = '&quot;';
	  $replacement[5] = '&#39;';
	  $replacement[6] = '&#37;';
	  $replacement[7] = '&#40;';
	  $replacement[8] = '&#41;';
	  $replacement[9] = '&#43;';
	  $replacement[10] = '&#45;';
	  
	  
	  
	  return preg_replace($pattern, $replacement, $str);
	}
	
	// make int int!
	function sanitize_int($integer, $min='', $max='')
	{
	  $int = intval($integer);
	  if((($min != '') && ($int < $min)) || (($max != '') && ($int > $max)))
		return FALSE;
	  return $int;
	}
	
	// make float float!
	function sanitize_float($float, $min='', $max='')
	{
	  $float = floatval($float);
	  if((($min != '') && ($float < $min)) || (($max != '') && ($float > $max)))
		return FALSE;
	  return $float;
	}
	
	// glue together all the other functions
	function sanitize($input, $flags, $min='', $max='')
	{
	  if($flags & $this->UTF8) $input = $this->my_utf8_decode($input);
	  if($flags & $this->PARANOID) $input = $this->sanitize_paranoid_string($input, $min, $max);
	  if($flags & $this->INT) $input = $this->sanitize_int($input, $min, $max);
	  if($flags & $this->FLOAT) $input = $this->sanitize_float($input, $min, $max);
	  if($flags & $this->HTML) $input = $this->sanitize_html_string($input, $min, $max);
	  if($flags & $this->SQL) $input = $this->sanitize_sql_string($input, $min, $max);
	  if($flags & $this->LDAP) $input = $this->sanitize_ldap_string($input, $min, $max);
	  if($flags & $this->SYSTEM) $input = $this->sanitize_system_string($input, $min, $max);
	  return $input;
	}
	
	function check_alphanumeric($str, $extra = false){
		$p = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789' . $extra;
		if( strspn($str, $p) < strlen($str) )
			return false;
		else
			return true;
	}
	
	function check_alpha($str, $extra = false){
		$p = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . $extra;
		if( strspn($str, $p) < strlen($str) )
			return false;
		else
			return true;
	}
	
	function check_numeric($str, $extra = false){
		$p = '0123456789' . $extra;
		if( strspn($str, $p) < strlen($str) )
			return false;
		else
			return true;
	}
	
	function validate_email ($address) {
		return (ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'. '@'. '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.' . '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $address));
	}
	
	function fixEncoding($in_str) 
	{ 
	  $in_str = str_replace("’","'",$in_str);
	  $cur_encoding = mb_detect_encoding($in_str) ; 
	  if($cur_encoding == "UTF-8" && mb_check_encoding($in_str,"UTF-8")) 
		return $in_str; 
	  else 
		return utf8_encode($in_str); 
	}
}


function sanitize_html_string($string){
	return Sanitize::sanitize_html_string($string);
}

?>
