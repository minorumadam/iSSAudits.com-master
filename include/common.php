<?
putenv("TZ=GMT");	
/**
Find File Function

	Needed to create the dynamic include process
	Below.
*/
 function findfiles($location='',$fileregex='') {
    if (!$location or !is_dir($location) or !$fileregex) {
       return false;
    }
 
    $matchedfiles = array();
 
    $all = opendir($location);
    while ($file = readdir($all)) {
       /*if (is_dir($location.'/'.$file) and $file <> ".." and $file <> ".") {
          $subdir_matches = findfiless($location.'/'.$file,$fileregex);
          $matchedfiles = array_merge($matchedfiles,$subdir_matches);
          unset($file);
       }
       else*/if (!is_dir($location.'/'.$file)) {
          if (preg_match($fileregex,$file)) {
             array_push($matchedfiles,$location.'/'.$file);
          }
       }
    }
    closedir($all);
    unset($all);
    return $matchedfiles;
 }
 // END FIND FILE
 
 function import($m){
   if( file_exists( IMPORT . $m . '.php' ) ){
    include_once( IMPORT . $m . '.php' );
    return true;
   }
   else
     return false;
 }
 function import_folder($folder){
   if( is_dir( IMPORT . $folder ) ){
    foreach(glob(IMPORT . $folder.'/*.php') as $file)
        include_once($file);
    return true;
   }
   else
     return false;
 }
 
 /* 
 
 	DYNAMIC INCLUDE PROCESS
 	
 */

	//INCLUDE COMMON FUNCTIONS
	$files = findfiles(dirname(__FILE__) . '/common/','/\.(php)$/'); 
	if($files) {
		while (list($key, $value) = each($files)) {
			include_once("$value");
		}
	}
//set action to $action for easy access
$action = "";
@$action = $_GET['action'];

// Fix ridiculous Site5 bug
if($_POST)$_POST = MiscFunctions::array_strip_slashes($_POST);
if($_GET)$_GET = MiscFunctions::array_strip_slashes($_GET);
		
@session_start();

