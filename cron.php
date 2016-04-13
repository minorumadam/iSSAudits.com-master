<?
define('CRON', true);

$action = $argv[1];

include( 'include/common.php' );
$db = new MySQLDB;
$db->connect();

$all = opendir(__DIR__ . '/include/cron/');
    while ($file = readdir($all)) {
       if (!is_dir('include/cron/'.$file)) {
          if (preg_match('/\.(php)$/',$file)) {
             array_push($files,'include/cron/'.$file);
          }
       }
    }
    closedir($all);
    unset($all);
	
if($files) {
	while (list($key, $value) = each($files)) {
		include_once("$value");

	}
}

if($argv[1] && function_exists($argv[1])){
	if( $argv[2] != 'cr0nj0b' ){
		echo 'failed login';
		exit;
	}

	print(date('r') . " Running job " . $argv[1] . "\n");

	$action_function = $argv[1];
	$data = $argv;
	unset($data['action']);
	$action_function($data);
}

?>