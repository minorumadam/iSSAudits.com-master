<?


if(!$_User->u_id){
	include( MODULE . 'login.php' );
	
?>
	
    <!-- Start of page: #splash -->
    <div data-role="page" id="splash" class="splashbg">
        <div class="splash">
            <img src="/images/site/splash.png" alt="splash" />
        </div>
    </div>
    <!-- /splash -->
 
<!-- Start of page: #login -->
    <div data-role="page" id="home" class="page-background">
        <div data-role="header" class="header" data-theme="none">
            <div class="ui-grid-b navbar">
                <div class="ui-block-a">
                   
                </div>
                <div class="ui-block-b">
                   Login
                </div>
                
            </div>
            <!-- /grid-b -->

        </div>
        <!-- /header -->
<form id="loginform" method="post" action="">
        <div role="main" class="splashbg content-login">
            <div class="ui-body auditsectioncontent">
<input type="text" name="username" id="username" placeholder="User Name/Email" value="">

<input type="text" name="password" id="" placeholder="Password" value="">
            </div>
        </div>
		<a onclick="document.getElementById('loginform').submit()"  class="greenbtn">Submit</a>
        </form>
    </div>
    <!-- /auditsection -->
   
   

	
<?
}

else

{ 


	if (empty($_sub))
	{?>	
   <!-- Start of page: #splash -->
    <div data-role="page" id="splash" class="splashbg">
        <div class="splash">
            <img src="/images/site/splash.png" alt="splash" />
        </div>
    </div>
    <!-- /splash -->
  <? } ?>


    <!-- Start of page: #home -->
    <div data-role="page" id="home" class="homebg">
        <div data-role="header" class="header" data-theme="none">
            <div class="ui-grid-a navbar">
				<div class="ui-block-a">Welcome <?=$_User->first_name?>!</div>
				<div class="ui-block-b"><?if($_User->client_logo){?><a href="/#home"><img src="<?=$_User->client_logo?>" class="client_logo" /></a><?}?></div>
				<div class="ui-block-c"> <a href="/?logout" rel="external" class="logout-icon ui-link"></a></div>
            </div>
            <!-- /grid-b -->
        </div>
        <!-- /header -->

        <div role="main">
            <div class="ui-body homecontent">

                <div class="homeiconholder">
                    <ul>
                        <li>
                            <a href="/available/"  rel="external"><img src="/images/site/availableaudit-icon.png"></a>
                            <span>Available <br>Audits </span>
                        </li>
                        <li>
                            <a href="/active/"  rel="external"><img src="/images/site/activeaudit-icon.png"></a>
                            <span>Active <br>Audits</span>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <a href="/support/"  rel="external"><img src="/images/site/contact-icon.png"></a>
                            <span>Contact Account <br> Manager</span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
    <!-- /splash -->



      
    <?

}



?>
