
<script id="panel-init">
		$(function() {
			$( "body>[data-role='panel']" ).panel();
		
		});
		
	</script>
<div data-role="page" id="contact" class="thankyou page-background">
  <div data-role="header" class="header" data-theme="none">
    <div class="ui-grid-b navbar">
      <div class="ui-block-a"> <a href="#slidepanel" class="navbar-icon"></a> </div>
      <div class="ui-block-b"> Contact </div>
      <div class="ui-block-c"> 
		  <a href="/?logout" rel="external" class="logout-icon"></a> 
	 </div>
    </div>
    <!-- /grid-b --> 
  </div>
  <div role="main">
    <div class="ui-body homebody">
      <p> <span>If you have any questions or need assistance, please contact your Account Manager</span></p>
      <p>Account Manager: <a href="mailto:<?=$client['am_email']?>"><?=$client['am_name']?></a><BR>
      Email: <a href="mailto:<?=$client['am_email']?>"><?=$client['am_email']?></a><BR>
      Phone: <a href="tel:<?=$client['am_phone']?>"><?=$client['am_phone']?></a> </p>
    </div>
  </div>
</div>
<div data-role="panel" id="slidepanel" data-position="left" data-display="overlay" data-theme="a">
  <h3>Navigation</h3>
  <p><a href="/"  rel="external" class="ui-btn ui-shadow ui-corner-all">Home</a></p>
  <p><a href="/active/"  rel="external" class="ui-btn ui-shadow ui-corner-all">Active Audits</a></p>
  <p><a href="/available/"  rel="external" class="ui-btn ui-shadow ui-corner-all">Available Audits</a></p>
  <!-- panel content goes here --> 
</div>
