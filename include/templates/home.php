<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iSS Audits</title>
    <link rel="stylesheet" href="/css/jquery.mobile-1.4.5.min.css">
    <link rel="stylesheet" href="/css/colorbox.css">
    <link rel="stylesheet" href="/css/style.css.php">
	<link rel="stylesheet" href="/css/jquery-mobile-datebox-master/jqm-datebox.css">
    <link rel="shortcut icon" href="/favicon.ico">
    <link href="http://www.issaudits.com/images/icons/main/apple-touch-icon.png" rel="apple-touch-icon" />

<link href="http://www.issaudits.com/images/icons/main/apple-touch-icon-76x76.png" rel="apple-touch-icon" sizes="76x76" />
<link href="http://www.issaudits.com/images/icons/main/apple-touch-icon-120x120.png" rel="apple-touch-icon" sizes="120x120" />
<link href="http://www.issaudits.com/images/icons/main/apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152" />
<link href="http://www.issaudits.com/images/icons/main/apple-touch-icon-180x180.png" rel="apple-touch-icon" sizes="180x180" />
<link href="http://www.issaudits.com/images/icons/main/icon-hires.png" rel="icon" sizes="192x192" />
<link href="http://www.issaudits.com/images/icons/main/icon-normal.png" rel="icon" sizes="128x128" />
<link rel="stylesheet" href="/js/addtohome/addtohomescreen.css">

    <script src="/js/jquery.js"></script>
    <!--<script src="../_assets//js/index.js"></script>-->
    <script src="/js/jquery.mobile-1.4.5.min.js"></script>
	<script src="/js/jquery-mobile-datebox-master/jqm-datebox.core.js"></script>
	<script src="/js/jquery-mobile-datebox-master/jqm-datebox.mode.calbox.js"></script>
	<!--<script src="/js/jquery-mobile-datebox-master/jqm-datebox.mode.custombox.js"></script>
	<script src="/js/jquery-mobile-datebox-master/jqm-datebox.mode.customflip.js"></script>-->
	<script src="/js/jquery-mobile-datebox-master/jqm-datebox.mode.datebox.js"></script>
	 <!--<script src="/js/jquery-mobile-datebox-master/jqm-datebox.mode.flipbox.js"></script>
	<script src="/js/jquery-mobile-datebox-master/jqm-datebox.mode.slidebox.js"></script>--> 
	<script src="/js/jquery-mobile-datebox-master/jqm-datebox.lang.utf8.js"></script>
	<script src="/js/jquery.colorbox.js"></script>
	<script src="/js/addtohome/addtohomescreen.js"></script>
	<style>
		
	@import url(http://fonts.googleapis.com/css?family=Raleway:400,500,600);
	html {
	-webkit-text-size-adjust:100%;
	-ms-text-size-adjust:100%
	}
	#cboxLoadedContent p{
		font-size: 0.7em !important;
		}
	</style>
</head>

<body>

<?=gen_feedback()?>
<?=$__output__?>
   
	<? if(empty($_sub))
	{ ?>
 <input type="hidden" value="http://www.issaudits.com/images/icons/main/icon-normal.png" id="homescreenicon" />
 <input type="hidden" value="main" id="getsubdomainname" />
<? } ?>
</body>
  <script src="/js/main.js"></script>
</html>
