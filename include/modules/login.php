<?

if( $post['username'] ){
	$feedback = new Feedback();

	if( !$post['username'] || !$post['password'] )
		$feedback->add(_("Please enter your email and password"));
	else{
		
		if(!User::login($post['username'], $post['password'], $post['remember'])){
			$feedback->label(_("Unable to log in."));
			$feedback->add(_("Please make sure you entered the correct password and your account is set up with Audit privelages ."));
			$feedback->type('fail');
		}
		else
		{
			$feedback->label(_("Logged in as " . $_SESSION['first_name'] . ' ' . $_SESSION['last_name']));
			
            header('Location: /');	
			exit;
		}
	}
	
}
 ?>
