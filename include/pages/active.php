<? 
$template = "main";

if ($request[2]=="cancel" && is_numeric($request[3]))
{
	$feedback = new Feedback;
	$feedback->label('Audit Canceled');
	
		$data['query_type'] = 'cancel';
		$data['id'] = $request[3];
		$result=$api->querydb('Audit',$data,"array");
		if($result['error']) 
		{
			$feedback->label('Audit Cancel Faled');
			$feedback->add($result['error']);
			$feedback->type("fail");
		}
		else $feedback->add($result['message']);
		$_SESSION['feedback_'] = $feedback;
		header('Location: /active/');	
		


}
$audits=$api->querydb('Active',$data,"array");

	
?>
<script id="panel-init">
		$(function() {
			$( "body>[data-role='panel']" ).panel();
		
		});
		
	</script>

<!-- Start of page: #availableaudit -->

<!-- /availableaudit end -->

<? if ($audits)
   {
	?>

<div data-role="page" id="activeaudit">
  <div data-role="header" class="header" data-theme="none">
    <div class="ui-grid-b navbar">
      <div class="ui-block-a"> <a href="#slidepanel" class="navbar-icon"></a> </div>
      <div class="ui-block-b"> <?if($_User->client_logo){?><a href="/#home"><img src="<?=$_User->client_logo?>" class="client_logo" /></a><?}?></div>
      <div class="ui-block-c"> <a href="/?logout"  rel="external" class="logout-icon"></a></div>
      <!-- /grid-b --> 
      
    </div>
  </div>
  <!-- /header -->
  
  <div role="main">
    <div class="ui-body banner-text">
      <h3>Active Audits</h3>
      <p>This is a list of your active audits. Please submit them when they are complete and they will be removed from your list. If you wish to cancel them and delete your data, select audit and hit cancel</p>
    </div>
    <?=gen_feedback()?>
    <div class="ui-body active-items">
      <ul>
        <? foreach ($audits as $audit)
                   {?>
        <li> <a href="#audit-<?=$audit['id']?>"> <span class="link-heading">
          <?=$audit ['title']?>
          -
          <?=$audit ['shop_name']?>
          </span> <span class="thumbnail"><img src="<?=$audit['logo']?>"></span> <span class="info"> <span class="activelink-heading">
          <?=$audit['location']?>
          </span> <span class="activelink-address">
          <?=$audit['address']?>
          <BR>
          Audit Initiated:
          <?=$audit['assigned_date']?>
          <BR>
          Audit ID: #
          <?=$audit['id']?>
          </span> </span> </a> </li>
        <? } ?>
      </ul>
    </div>
  </div>
  <!-- /content --> 
</div>
<!-- /activeaudit end -->

<?
	foreach ($audits as $audit)
	{ 
    	?>
<div data-role="page" id="audit-<?=$audit['id']?>" class="page-background auditsectionbg">
  <div data-role="header" class="header" data-theme="none">
    <div class="ui-grid-b navbar">
      <div class="ui-block-a"> <a href="#activeaudit" class="pageback-icon"></a> </div>
      <div class="ui-block-b"> Audit </div>
    </div>
    <!-- /grid-b --> 
    
  </div>
  <!-- /header -->
  
  <div role="main" class="content-bgshadow">
    <div class="ui-body auditsectioncontent">
      <div class="pagethumb">
        <ul>
          <li>
            <div class="thumbnail"><img src="<?=$audit['logo']?>"></div>
          </li>
        </ul>
      </div>
      <h2>
        <?=$audit['location']?>
      </h2>
      <p>
        <?=$audit['address_full']?>
      </p>
      <h3>
        <?=$audit['phone']?>
      </h3>
        <h3>
        Audit #<?=$audit['id']?>
      </h3>
      <div class="auditsection-iconset">
        <ul>
          <li><a href="/audit/<?=$audit['id']?>/home/" rel="external" class="start-icon" title="Start"></a></li>
          <li><a href="/active/cancel/<?=$audit['id']?>" onclick="return confirm('Are you sure you want to cancel and delete your work ?')" rel="external" class="cancel-icon" title="Cancel"></a></li>
         <!-- <li><a href="" rel="external" class="location-icon" title="Map"></a></li>-->
          <?if($audit['phone']){?><li><a href="tel:<?=$audit['phone']?>" class="phone-icon" title="Call"></a></li><?}?>
        </ul>
      </div>
      <hr class="auditsection-hr">
      <div class="ui-grid-b auditsection-grid">
        <div class="ui-block-a">
          <p>Title<br>
            <b>
            <?=$audit ['title']?>
            </b> </p>
        </div>
        <div class="ui-block-b">
          <p>Form<br>
            <b>
            <?=$audit ['shop_name']?>
            </b> </p>
        </div>
        <div class="ui-block-c">
          <p>Started<br>
            <b>
            <?=$audit['assigned_date']?>
            </b> </p>
        </div>
      </div>
      <hr class="auditsection-hr">
      <!-- /grid-b -->
      
      <div class="auditsection-description">
        <p>
          <?=$audit['description']?>
          <br><br>
          <b>To continue working on an audit, click the start button (airplane icon).</b> <br>
          <br>
          You can hit cancel at any time (X icon). This will remove the audit from your device and your work will be lost</p>
      </div>
    </div>
  </div>
</div>
<?		
	}//end for each
}
else
{ //no audits
?>
<div data-role="page" id="activeaudit">
  <div data-role="header" class="header" data-theme="none">
    <div class="ui-grid-b navbar">
      <div class="ui-block-a"> <a href="#slidepanel" class="navbar-icon"></a> </div>
      <div class="ui-block-b"> <?if($_User->client_logo){?><a href="/#home"><img src="<?=$_User->client_logo?>" class="client_logo" /></a><?}?> </div>
      <div class="ui-block-c"> <a href="/?logout" rel="external" class="logout-icon"></a> </div>
      <!-- /grid-b --> 
      
    </div>
  </div>
  <!-- /header -->
  
  <div role="main">
    <div class="ui-body banner-text">
      <h3>Active Audits</h3>
    </div>
    <div class="ui-body active-items">
      <p>You do not have any active audits.  Please go to available audits to begin a new form.</p>
    </div>
    <?=gen_feedback()?>
  </div>
  <!-- /content --> 
</div>
<? } ?>

<!-- Start of page: #availableauditinner --> 

<!-- /availableauditinner end --> 
<!--  panel  -->
<div data-role="panel" id="slidepanel" data-position="left" data-display="overlay" data-theme="a">
  <h3>Navigation</h3>
  <p><a href="/" rel="external" class="ui-btn ui-shadow ui-corner-all">Home</a></p>
  <p><a href="/available/" rel="external" class="ui-btn ui-shadow ui-corner-all">Available Audits</a></p>
  <p><a href="/support/"  rel="external"class="ui-btn ui-shadow ui-corner-all">Contact Support</a></p>
  <!-- panel content goes here --> 
</div>
<!--  panel  --> 

