<?
class Emails{
	
	public $shopper_id 	=	false;
	public $user 	=	false;
	public $category 	=	false;
	public $from_name 	=	"iSecretShop";
	public $from_email 	=	false;
	public $to_name 	=	false;
	public $to_email 	=	false;
	public $reply 	=	"no-reply@iSecretShop.com";
	public $subject 	=	false;
	public $message 	=	false;
	public $html 	=	false;
	public $files 	=	false;
	public $sendgrid_key = SENDGRID_MAIN;
	
	function __CONSTRUCT(){
		
	}
	
	function send(){
		
		$server = Emails::check_server();
		
		if ($server =='none')
		{
			///don't send - totally blocked
			
		}else if ($server =='localhost' || $this->files)
		{
			//can't currently send files via send grid - we do not save them on server first...
			if (!$this->files)
			{
				if ($this->user =='availableshops');
				{
					$this->message = str_replace('</body></html>','',$this->message);
					$this->message .= Emails::shopper_remove_link($this->shopper_id).'</body></html>';	
				}
				$this->mail_html();
			}
			else
				$this->mail_with_attachments();
			
		}else
		{
			$this->mail_sendgrid();
			
		}
	}
	
	function check_server(){
		global $db;
		$domain = explode("@",$this->to_email);
		$domain = $domain[1];
		$server=$db->query("SELECT server from domains where user='".$this->user."' and (domain='*' OR domain='".$domain."')");
		if ($server)
			return $server[0][server];
		$server=$db->query("SELECT server from domains where (user='".$this->user."' OR user='*') and domain='".$domain."'");
		if ($server)
			return $server[0][server];	
		return false;	
	}
	
	function shopper_remove_link() {
		$hash=md5($this->shopper_id);
		$footer =  "\n\nTo remove yourself from future notification emails, please click: http://www.isecretshop.com/removeEmail/?email=".$this->to_email."&str=$hash\n\n";
		return $footer;
	}
	
	function mail_html() {
		require_once "Mail.php";
		
		if (!strpos($this->from_email,"isecretshop.com")	)
			$this->from_email = "agentsupport@isecretshop.com";
			
		$messageID='<'.time()."-".$this->from_email.'>';
		
		$_mailbox        =   Mail::factory('smtp', array(
		  'host'         => 'mail.issdirector.com',
		  'auth'         =>  true,
		  'username'     => 'reports@issdirector.com',
		  'password'     => 'aVMraD[xE7p#',
		  'persist'      =>  FALSE  ));
  
		$_headers        =   array(
		  'From'         => $this->from_name.' <'.$this->from_email.'>',
		  'Reply-To'     => $this->from_name.' <'.$this->reply.'>',
		  'To'           => $this->to_name.' <'.$this->to_email.'>',
		  'Subject'      => $this->subject,
		  'Date' => date("r"), 
		  'Content-Type' => 'text/html',
		  'Message-ID'   => $messageID,
		  'MIME-Version' => '1.0'    );
  
		$_to_eml  =  $_headers['To'];
		if(!$this->html)
			$this->message = '<html><body>'.$this->message.'</body></html>';
		//echo 'local';
		//print_r($_headers);
		$_mail    =  $_mailbox->send( $_to_eml, $_headers, $this->message );
		//echo $_mail;
		//$_mail    =  $_mailbox->send( "jennifer@isecretshop.com", $_headers, $this->message );
	 	
	/*	if    (PEAR::isError($_mail)) {
			mail("jennifer@isecretshop.com","mail failed","{$_to_eml}".$_mail->getMessage());
  			echo date( " Y-m-d H:i:s  ->  " ) . "email to {$_to_eml} failed, details : " . $_mail->getMessage() . "\n\n".$from;  
  		}  */
//else  {
  //echo date( " Y-m-d H:i:s  ->  " ) . "email sent to {$_to_eml} !\n\n";    }
 
	}
	
	
	function mail_with_attachments() {
		require_once "Mail.php";
		require_once('Mail/mime.php');
		
		if (!strpos($this->from_email,"isecretshop.com")	)
			$this->from_email = "agentsupport@isecretshop.com";
			
		$_boundary       =   sha1(date('r')); 		
		$messageID='<'.time()."-".$this->from_email.'>';
			
		$crlf = "\r\n";
		$_mailbox        =   Mail::factory('smtp', array(
		  'host'         => 'mail.isecretshop.com',
		  'auth'         =>  true,
		  'username'     => 'outgoing@isecretshop.com',
		  'password'     => 'aVMraD[xE7p#',
		  'persist'      =>  FALSE  ));
  
		$_headers        =   array(
		  'From'         => $this->from_name.' <'.$this->from_email.'>',
		  'Reply-To'     => $this->from_name.' <'.$this->reply.'>',
		  'To'           => $this->to_name.' <'.$this->to_email.'>',
		  'Subject'      => $this->subject,
		  'Message-ID'   => $messageID,
		  'Date' => date("r")
		  );
			//$content = '<html>'.$content.'</html>';
	
		$mime = new Mail_mime($crlf);
		
		
        
		if(!$this->html)
		{
			$this->text_message =$this->message;
			$this->message = '<html><body>'.$this->message.'</body></html>';
		}
		$mime->setTXTBody($this->text_message);
        $mime->setHTMLBody($this->message);
		
		if ($this->files)
		{	
			  foreach ($this->files as $file){
				  
				  if (($file[name] != ".") &&	($file[name] != "..") && !strpos($file[name],"php") && !strpos($file[name],"htm")&& !strpos($file[name],"css"))
				  {
					  if (strpos($file[name],".pdf"))
						  $content_type = "Application/pdf"; 
					  else if (strpos($file[name],".csv"))
						  $content_type = "Application/octet-stream"; 
					  else if (strpos($file[name],".jpg"))
						  $content_type = "image/jpg"; 
					  else if (strpos($file[name],".gif"))
						  $content_type = "image/gif"; 		
					  
					  $mime->addAttachment($file[data],$content_type, $file[name], false);
								  
				  }
			  }
			 // error_log(count($this->files).print_r($_headers,1));
		} 
		
	    $_to_eml  =  $_headers['To'];
		//$message = '<html>'.$message.'</html>';
		//$body = $mime->get();
		$mimeparams['text_encoding']="8bit"; 
		$mimeparams['text_charset']="UTF-8"; 
		$mimeparams['html_charset']="UTF-8"; 
		$mimeparams['head_charset']="UTF-8"; 
		
		$body = $mime->get($mimeparams);
		$_headers = $mime->headers($_headers);
		
		$_mail = $_mailbox->send( $_to_eml, $_headers, $body );
		//error_log("after".print_r($_mail,1));
	}

	function mail_sendgrid(){
		import('class.SendGrid');
		
		$sendgridweb = new sendgridWeb($this->user,$this->sendgrid_key ); 
		$xsmtpapi = array(
			'unique_args' => array(
					'shopper_id' => $this->shopper_id
				),
		  'category' => $this->category,
		  'filters' => array(
				'opentrack'=> array(
					'settings' => array(
						"enable" => 1
					)
				),
				'clicktrack'=> array(
					'settings' => array(
						"enable" => 1
					)
				)
			)
		);
		
		$response = $sendgridweb->mail_send( $this->to_email , $this->to_name, $xsmtpapi, $this->subject , $this->message, $this->text_message , $this->from_email , $bcc ='' , $this->from_name, $this->reply, $date='' , $this->files, $headers=''); 
		//$response = $sendgridweb->mail_send( "jennifer@isecretshop.com" , $this->to_name, $xsmtpapi, $this->subject , $this->message, $this->text_message , $this->from_email , $bcc ='' , $this->from_name, $this->reply, $date='' , $files='' , $headers=''); 
		error_log(print_r($response,1));		
	}
	
}

?>