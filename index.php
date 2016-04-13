<? 
require_once('./include/common.php');

// Import important classes

$db=getDB();



if(isset($_SESSION['feedback_'])){
    $feedback = $_SESSION['feedback_'];
    unset($_SESSION['feedback_']);
}


$request = explode('?', $_SERVER['REQUEST_URI']);
$url = $request[0];
$request = explode('/', $url);
$url = $_SERVER['HTTP_HOST'] . $url;
//mail("jennifer@apptivatellc.com","request",$_SERVER['REQUEST_URI']);
if( isset($_GET['logout']) ){
	unset($_SESSION['_User']);
	unset($_SESSION['_Client']);
	setcookie('uniqid', '', time()-3600, '/', '.'.SITE_DOMAIN);
	//header("Location: https://" . $url);
	
	
	 header('Location: /');	
	exit;
}

if( isset($_COOKIE['uniqid']) && !$_SESSION['_User'])
	include( MODULE . 'cookie.login.php' );


if( $_SESSION['_User']->u_id)
{
	$_User = $_SESSION['_User'];
	import("class.clientAPI");
	$api =	new ISSAPI();
	if(!$_SESSION['_Client'])
	{
		$_SESSION['_Client'] =  $api->get('Client',$_User->c_id,"array");
	}
	$client = $_SESSION['_Client'];
	//error_log("********************".print_r($client,1));
}
// Check to see if a page has been requested

$_sub = Subdomain::get_subdomain();
if( $request[1] && $_User || $request[1]=="test")
    $_page = $request[1];
	
else
{
	
	$_page = 'home';
	$template= "home";
}


if($_POST){
    $post = $_POST;
   
	$_SESSION['post_'] = $post;

}


$_page = str_replace('/', '', $_page);

if(file_exists(NAV . $_page . '.php')){
	//$_seo->get($_page);
	//include the page  */
	ob_start();
	include(NAV . $_page . '.php');
	$__output__ = ob_get_contents();
	ob_end_clean();
}

if (!empty($_sub) && !$_User)
{
	$template= $_sub."/home";
}
if( empty($template))
    $template = 'main';
if( empty($_bodyStyle) )
	$_bodyStyle='background:white';

if( $template && file_exists( TEMPLATE . $template . '.php' ) ){
	include(TEMPLATE . $template . '.php');
}
else 
	echo $__output__;

?>