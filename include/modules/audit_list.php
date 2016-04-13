<div data-role="header" class="header" data-theme="none">
    <div class="ui-grid-b navbar">
      <div class="ui-block-a"> <a href="#" data-rel="back" class="pageback-icon"></a> </div>
      <div class="ui-block-b"> <a href="#" class="pageavailable-icon"></a> </div>
      <div class="ui-block-c"> <a href="#" class="logout-icon"></a> </div>
    </div>
    <!-- /grid-b --> 
    
  </div>
  <!-- /header -->
  
  <div role="main">
  
    <div class="ui-body banner-text">
      <h3>Available Audits</h3>
      <h4><?=$audit_list[0]['location']?></h4>
      <p>Click the audit you would like added to your active audit list</p>
    </div>
    <?=gen_feedback()?>
    <div id="auditsubmitwait" style="display:none;margin-bottom: 8px;text-align: center;">Please wait, adding to your active audit list.</div>
    <div class="ui-body available-items content-bgshadow">
	  <ul>
      <? if ($audit_list) foreach($audit_list as $audit)
	  {
	 ?>
	    <li class="auditselectli" data-audit="<?=$audit['id']?>">
          <h3><?=$audit['title']?></h3>
          <div class="thumbnail"><img src="<?=$audit['logo']?>" ></div>
		 <!-- <div class="availableaudit-radio">
			<fieldset data-role="none" data-mini="true" class="content-radioicon single-radioicon">
			  <input type="checkbox" name="audit[<?=$audit['id']?>]" id="audit[<?=$audit['id']?>]" >
			  <label for="audit[<?=$audit['id']?>]"></label>
			</fieldset>
		  </div>-->
		  <div class="info">
            <h4><?=$audit['shop_name']?></h4>
            <p>Dates: <?=$audit['date_details']?></p>
            <p>Audit ID: #<?=$audit['id']?></p>
          </div>
         
        </li>
       <? } ?>
      </ul>
  </div>
  <!-- /content --> 
  <!--<a href="#" onclick="document.getElementById('availableform').submit()" class="greenbtn">Check Out Audit</a>--> 
  </div> <!-- /main -->
  <script>
  $('.auditselectli').click(function(){
		 var auditid = $(this).attr('data-audit');
		 $('#auditid').val(auditid);
		 $('#confirmAuditTitle').html('Confirm Audit #'+auditid);
	     location.href='#audits-confirm';
	  });
  </script>
