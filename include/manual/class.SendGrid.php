<?php
require_once "/home/".SITE_ACCOUNT."/public_html/include/manual/SendGrid/web.php";
require_once "/home/".SITE_ACCOUNT."/public_html/include/manual/SendGrid/SubUser.php";
require_once "/home/".SITE_ACCOUNT."/public_html/include/manual/SendGrid/SubUserApi.php";

class SendGrid{
	public function check_user($admin_id){
		$admin = new Admin($admin_id);
		
			$admin_un = "iss_".$admin_id;	
			$sg_user = 'apptivate';
			$sg_api_key = SENDGRID_MASTER;
			
			$sendgridapi = new SubUserApi($sg_user, $sg_api_key, false);
			
			$user = $sendgridapi->getSubUser($admin_un);
			
			if(!$user->username)
			{
				$user = new SubUser($admin_un, SENDGRID_SUB, 'jennifer@isecretshop.com',
					"sg.isecretshop.com",$admin->profile['first_name'],$admin->profile['last_name'],"-","-","-","-","US"); // Optional arguments are available
				// Add the sub user to your account
				$sendgridapi->addSubUser($user);
				// Assign an IP to the user
				$user->assignIps(array("167.89.25.74"));
				// Enable and configure an app
				$user->enableApp("eventnotify", true, array(
					'processed' => false,
					'dropped' => true,
					'deferred' => false,
					'delivered' => false,
					'bounce' => true,
					'click' => false,
					'open' => false,
					'unsubscribe' => true,
					'spamreport' => true,
					'url' => "http://test.com/api/sendgrid/Event/"));
				
				$user->setEventPostUrl("eventnotify", array(
					'url' => "http://72.52.204.128/api/sendgrid/Event/"));	
					
			
				$user->enableApp("subscriptiontrack", true, array(
				'url' => 'https://isecretshop.com/unsubscribe/',	
					'text/html' => 'If you would like to stop receiving emails from this Mystery Shopping Provider <% click here %>.  If you no longer wish to be a mystery shopper for any Mystery Shopping Provider please email <a mailto:support@isecretshop.com>agentsupport@isecretshop.com</a>',
					'text/plain' => 'If you would like to stop receiving emails from this Mystery Shopping Provider click here <% %>.  If you no longer wish to be a mystery shopper for any Mystery Shopping Provider please email agentsupport@isecretshop.com',
					));
				
				$user->enableApp("opentrack", true, array());
			}
		
	}
}