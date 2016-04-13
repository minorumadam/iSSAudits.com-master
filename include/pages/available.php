<? 
$template = "main";
if($post['audit'])
{
	$auditid="";
	$feedback = new Feedback;
	$feedback->label('Success');
	foreach($post['audit'] as $id=>$v)
	{
		$auditid = $id;
		$data['query_type'] = 'start';
		$data['id'] = $id;
		$result=$api->querydb('Audit',$data,"array");
		if($result['error']) 
		{
			$feedback->label('Error');
			$feedback->add($result['error']);
			$feedback->type("fail");
		}

		else $feedback->add('Audit #'.$id.' started');
		$_SESSION['feedback_'] = $feedback;
	}
	if($auditid)
	 	header('Location: /audit/'.$auditid.'/home/');
}

$data['query_type'] = 'search';
$audits=$api->querydb('Search',$data,"array");

		
?>
<script id="panel-init">
		$(function() {
			$( "body>[data-role='panel']" ).panel();
		});
</script>
<!-- Start of page: #availableaudit -->
<!-- /availableaudit end -->
<? if ($audits[levels] && !isset($_GET['audit']))
   {
	?>

<div data-role="page" id="level" class="page-background">
  <div data-role="header" class="header" data-theme="none">
    <div class="ui-grid-b navbar">
      <div class="ui-block-a"> <a href="#slidepanel" class="navbar-icon"></a> </div>
      <div class="ui-block-b"> <?if($_User->client_logo){?><a href="/#home"><img src="<?=$_User->client_logo?>" class="client_logo" /></a><?}?></div>
      <div class="ui-block-c"> <a href="/?logout"  rel="external" class="logout-icon"></a> </div>
    </div>
    <!-- /grid-b --> 
    
  </div>
  <!-- /header -->
  
  <div role="main">
    <div class="ui-body banner-text">
      <h3>Available Audits</h3>
      <p>Drill down to choose audits to start</p>
    </div>
    <?=gen_feedback()?>
    <div class="ui-body region-items">
      <ul>
        <? foreach ($audits[levels] as $l1=>$level1)
                               {?>
        <li data-role="none"> <a href="#<?=(empty($level1[levels])?"loc":"level").'-'.$l1.'-'.$l2.'-'.$l3?>" class="region-info">
          <?=$level1 ['name']?>
          </a> </li>
        <? }?>
      </ul>
    </div>
  </div>
  <!-- /content --> 
  
</div>
<?
	foreach ($audits[levels] as $l1=>$level1)
	{ 
    	if(empty($level1[levels]))
		{ 
			if( $level1[locations]) {
				$locations = $level1[locations];
				include( MODULE . 'loc_list.php' ); 
			
			}// if locations
		} else  //end $level1[levels] empty
		{ // show levels page and check for more levels
		?>
<div data-role="page" id="level-<?=$l1?>-<?=''?>-<?=''?>" class="page-background">
  <div data-role="header" class="header" data-theme="none">
    <div class="ui-grid-b navbar">
      <div class="ui-block-a"> <a href="#" data-rel="back"  class="pageback-icon"></a> </div>
      <div class="ui-block-b"> <?if($_User->client_logo){?><a href="/#home"><img src="<?=$_User->client_logo?>" class="client_logo" /></a><?}?> </div>
      <div class="ui-block-c"> <a href="/?logout"  rel="external" class="logout-icon"></a></div>
    </div>
    <!-- /grid-b --> 
    
  </div>
  <!-- /header -->
  
  <div role="main">
    <div class="ui-body banner-text">
      <h3>Available Audits</h3>
      <p>Drill down to choose audits to start</p>
    </div>
    <div class="ui-body region-items">
      <ul>
        <? foreach ($level1[levels] as $l2=>$level2)
                   {?>
        <li data-role="none"> <a href="#<?=(empty($level2[levels])?"loc":"level").'-'.$l1.'-'.$l2.'-'.$l3?>" class="region-info">
          <?=$level2 ['name']?>
          </a> </li>
        <? }?>
      </ul>
    </div>
  </div>
  <!-- /content --> 
  
</div>
			<? foreach ($level1[levels] as $l2=>$level2)
		   { 
				if(empty($level2[levels]))
				{ 
					if( $level2[locations]) {
						$locations = $level2[locations];
						include( MODULE . 'loc_list.php' ); 
			
					}// if locations
 			} else
			{ // show levels page and check for more levels
				?>
                <div data-role="page" id="level-<?=$l1?>-<?=$l2?>-<?=''?>" class="page-background">
                  <div data-role="header" class="header" data-theme="none">
                    <div class="ui-grid-b navbar">
                      <div class="ui-block-a"> <a href="#" data-rel="back" class="pageback-icon"></a> </div>
                      <div class="ui-block-b"> <?if($_User->client_logo){?><a href="/#home"><img src="<?=$_User->client_logo?>" class="client_logo" /></a><?}?> </div>
                      <div class="ui-block-c"> <a href="/?logout" rel="external" class="logout-icon"></a> </div>
                    </div>
                    <!-- /grid-b --> 
                    
                  </div>
                  <!-- /header -->
                  
                  <div role="main">
                    <div class="ui-body banner-text">
                      <h3>Available Audits</h3>
                      <p>Drill down to choose audits to start</p>
                    </div>
                    <div class="ui-body region-items">
                      <ul>
                        <? foreach ($level2[levels] as $l3=>$level3)
                                                            {?>
                        <li data-role="none"> <a href="#<?=(empty($level3[levels])?"loc":"level").'-'.$l1.'-'.$l2.'-'.$l3?>" class="region-info">
                          <?=$level3 ['name']?>
                          </a> </li>
                        <? }?>
                      </ul>
                    </div>
                  </div>
                  <!-- /content --> 
                  
                </div>
											<? foreach ($level2[levels] as $l3=>$level3)
                                            {                         							
                                                if( $level3[locations]) 
                                                {
                                                    $locations = $level3[locations];
                                                    include( MODULE . 'loc_list.php' ); 
                                            
                                                }// if locations
											}// foreach $level2[levels]
					}  //$level2[levels] not empty
									
							}// foreach $level1[levels]
					}//end $level1[levels] not empty
				}//foreach level1
			
		
	}else
	{ //no levels
	if( $audits[locations]) {
		//error_log(print_r($audits,1));
		$locations = $audits[locations];
		include( MODULE . 'loc_list.php' ); 
    
	}// if locations
} 

?>

<!-- Start of page: #availableauditinner --> 

<!-- /availableauditinner end --> 
<!--  panel  -->
<div data-role="panel" id="slidepanel" data-position="left" data-display="overlay" data-theme="a">
  <h3>Navigation</h3>
  <p><a href="/"  rel="external" class="ui-btn ui-shadow ui-corner-all">Home</a></p>
  <p><a href="/active/"  rel="external" class="ui-btn ui-shadow ui-corner-all">Active Audits</a></p>
  <p><a href="/support/"  rel="external" class="ui-btn ui-shadow ui-corner-all">Contact Support</a></p>
  <!-- panel content goes here --> 
</div>
<!-- /panel --> 

<div data-role="page" id="audits-confirm" class="page-background">
  <div data-role="header" class="header" data-theme="none">
    <div class="ui-grid-b navbar">
      <div class="ui-block-a"> <a href="#slidepanel" class="navbar-icon"></a> </div>
      <div class="ui-block-b"> <?if($_User->client_logo){?><a href="/#home"><img src="<?=$_User->client_logo?>" class="client_logo" /></a><?}?></div>
      <div class="ui-block-c"> <a href="/?logout"  rel="external" class="logout-icon"></a> </div>
    </div>
    <!-- /grid-b --> 
    
  </div>
  <!-- /header -->
  <? if ($audits) { ?>
  <div role="main">
    <div class="ui-body banner-text">
      <h3 id="confirmAuditTitle">Confirm Audit #</h3>
      <p>Are you ready to start the audit now?</p>
      <input type="hidden" value="" id="auditid" />
    </div>
    <?=gen_feedback()?>
    <div class="ui-body region-items">
	  <p id="auditProccess" style="text-align:center; display:none">Downloading questions ...</p>
      <a href="#" class="Submit auditselect"><span class="greenbtn">Start</span></a><br /><br />
      <a href="#audits-0-0--0" class="Submit" rel="external"><span class="greenbtn red">Cancel</span></a>
    </div>
  </div>
  <!-- /content --> 
  <? } else { ?>
<div role="main">
    <div class="ui-body banner-text">
      <h3 id="confirmAuditTitle">Error</h3>
      <p>No audits are loaded for your account.  Please contact your account manager.</p>
     
    </div>
    <?=gen_feedback()?>
    
  </div>

	<? } ?>  
</div>

<script>
$('.auditselect').click(function(){
	var auditid=$('#auditid').val();
	if(auditid){
		$('#auditProccess').show();
		$form = $("<form id='auditform' method='post' action='' data-ajax='false'></form>");
		$form.append('<input type="hidden" name="audit['+auditid+']"  value="1" />');
		$('body').append($form);
		$('#auditform').submit();
	}else{
	   location.href='#audits-0-0--0';
	}
});
</script>
