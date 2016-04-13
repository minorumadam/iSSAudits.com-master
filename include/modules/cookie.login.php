<?

$q = "SELECT * FROM uniqid WHERE id = '" . addslashes($_COOKIE['uniqid']) . "'";
$r = $db->query($q);
$r = $r[0];
if( $r && User::cookie_validate($r['email'], $r['password']) ){
		
}
else{
	unset($feedback);
	setcookie('uniqid', '', time()-36000, '/', '.'.SITE_DOMAIN);
}

?>