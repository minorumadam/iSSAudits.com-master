<div data-role="page" id="loc-<?=$l1?>-<?=$l2?>-<?=$l3?>" class="page-background">
  <div data-role="header" class="header" data-theme="none">
    <div class="ui-grid-b navbar">
      <? if (!is_numeric($l1)){ ?><div class="ui-block-a"> <a href="#slidepanel" class="navbar-icon"></a> </div> 
      <? }else{ ?>   <div class="ui-block-a"> <a href="#" data-rel="back" class="pageback-icon"></a></div>
      <? } ?>
      <div class="ui-block-b"> <a href="#" class="pageavailable-icon"></a> </div>
      <div class="ui-block-c"> <a href="#" class="logout-icon"></a> </div>
    </div>
    <!-- /grid-b --> 
    
  </div>
  <!-- /header -->
  
  <div role="main">
    <div class="ui-body banner-text">
      <h3>Available Audits</h3>
      <!--<p>Drill down to choose audits to check out</p>-->
    </div>
     <? if (empty($l1)){ ?> <?=gen_feedback()?><? } ?>
    <div class="ui-body region-items">
      <ul>
        <? if($locations) foreach ($locations as $k=>$loc)
        {?>
        <li data-role="none"> <a href="#<?='audits-'.$l1.'-'.$l2.'-'.$l3.'-'.$k?>" class="region-info">
          <?=$loc['name']?>
          </a> </li>
        <? }?>
      </ul>
    </div>
  </div>
  <!-- /content --> 
  
</div>
	<? if($locations) foreach ($locations as $k=>$loc)
	{ ?>
    <div data-role="page" id="<?='audits-'.$l1.'-'.$l2.'-'.$l3.'-'.$k?>">
      <? 
        $audit_list = $loc['audits'];
        include( MODULE . 'audit_list.php' ); ?>
    </div>
<? 
	}// foreach location