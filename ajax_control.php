<?
require_once('./include/common.php');

function unpurify($data){
	if(is_array($data)){
		foreach($data as $k=>$v){
			if(is_array($v)){
				$data[$k] = unpurify($v);
			}
			else{
				$v = str_replace('amp;', '&', $v);
				$v = str_replace('perc;', '%', $v);
				$data[$k] = $v;
			}
		}
	}
	return $data;
}

if($_REQUEST['action'] && function_exists('ajax_'.$_REQUEST['action'])){
	$action_function = 'ajax_'.$_REQUEST['action'];
	if($_GET)$data = $_GET;
	else if($_POST)$data = $_POST;
	unset($data['action']);
	if (isset ($data[data])) $data=$data['data'];
	$data = unpurify($data);
	$action_function($data);
}

?>