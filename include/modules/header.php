<header class="top_head">
  <div class="center clearfix"> <span class="welcome left">Welcome <?=$_User->first_name?>!</span>
    <ul class="short_nav right">
      <li><a href="/?logout"><i class="fa fa-unlock-alt"></i><span>Logout</span></a></li>
      <li><a href="<?=$_User->msp_id==24?"https://isecretshop.zendesk.com/hc/en-us/requests/new":"/contact/"?>"><i class="fa fa-question-circle"></i><span>Need Help</span></a></li>
      <li> <a href="/?lang=en_US"><img src="/images/site/b6da9714.flag.png" alt="English">English <i class="fa fa-chevron-down"></i></a>
      <? include( MODULE . 'languages.php' ); ?> 
     
      </li>
    </ul>
  </div>
  <!--end of the center--> </header>