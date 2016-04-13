<?php
session_start();
    $client = $_SESSION['_Client'];
	header("Content-type: text/css; charset: UTF-8");
	$color1 = ($client['highlight']?'#'.$client['highlight']:"01678C");
	$color2 = ($client['color2']?'#'.$client['color2']:"#015a7e");
	$color3 = ($client['color3']?'#'.$client['color3']:"#1e1e1e");
	$color4 = ($client['color4']?'#'.$client['color4']:"#8BAB3B");
	$color5 = ($client['color5']?'#'.$client['color5']:"#8e0201");

?>
/*------------------------  Embeded Font -----------------------*/
@font-face {
 font-family: 'latoregular';
 src: url('/fonts/lato-regular.eot');
 src: url('/fonts/lato-regular.eot?#iefix') format('embedded-opentype'), url('/fonts/lato-regular.woff2') format('woff2'), url('/fonts/lato-regular.woff') format('woff'), url('/fonts/lato-regular.ttf') format('truetype'), url('/fonts/lato-regular.svg#latoregular') format('svg');
 font-weight: normal;
 font-style: normal;
}
 @font-face {
 font-family: 'latobold';
 src: url('/fonts/lato-bold.eot');
 src: url('/fonts/lato-bold.eot?#iefix') format('embedded-opentype'), url('/fonts/lato-bold.woff2') format('woff2'), url('/fonts/lato-bold.woff') format('woff'), url('/fonts/lato-bold.ttf') format('truetype'), url('/fonts/lato-bold.svg#latobold') format('svg');
 font-weight: normal;
 font-style: normal;
}
@font-face {
 font-family: 'latoblack';
 src: url('/fonts/lato-black.eot');
 src: url('/fonts/lato-black.eot?#iefix') format('embedded-opentype'), url('/fonts/lato-black.woff2') format('woff2'), url('/fonts/lato-black.woff') format('woff'), url('/fonts/lato-black.ttf') format('truetype'), url('/fonts/lato-black.svg#latoblack') format('svg');
 font-weight: normal;
 font-style: normal;
}
 @font-face {
 font-family: 'latolight';
 src: url('/fonts/lato-light.eot');
 src: url('/fonts/lato-light.eot?#iefix') format('embedded-opentype'), url('/fonts/lato-light.woff2') format('woff2'), url('/fonts/lato-light.woff') format('woff'), url('/fonts/lato-light.ttf') format('truetype'), url('/fonts/lato-light.svg#latolight') format('svg');
 font-weight: normal;
 font-style: normal;
}
 @font-face {
 font-family: 'bree_ltlight';
 src: url('/fonts/ufonts.com_bree-light-opentype.eot');
 src: url('/fonts/ufonts.com_bree-light-opentype.eot?#iefix') format('embedded-opentype'), url('/fonts/ufonts.com_bree-light-opentype.woff2') format('woff2'), url('/fonts/ufonts.com_bree-light-opentype.woff') format('woff'), url('/fonts/ufonts.com_bree-light-opentype.ttf') format('truetype'), url('/fonts/ufonts.com_bree-light-opentype.svg#bree_ltlight') format('svg');
 font-weight: normal;
 font-style: normal;
}
/*------------------------  common -----------------------*/
ui-select .ui-btn{ 
	text-align:left; 
    color: #15addd; 
    font-family:"latobold"; 
    text-shadow:none; 
    font-size: 18px; 
} 
.ui-select .ui-btn.ui-btn-active{ 
    background-color:#15addd; 
    color: #333;  
} 
.page-background {
	background:#f5f5f5;
}
.header {
	/*background: <?=$color1?>;*/
	background:#fff;
	text-shadow:none;
	color:#015a7e;
	border:none;
}
.navbar {
	padding:13px 16px;
}
.navbar .ui-block-a {
	text-align:left;
}
.navbar .ui-block-b {
	text-align:center;
}
.navbar .ui-block-c {
	text-align:right;
	width: 33.333%;
}
.navbar-icon {
	width:26px;
	height:26px;
	display:inline-block;
	background:url("/images/site/navbar-icon.png") no-repeat;
	background-size: 26px 26px;
}
.logout-icon {
	width:26px;
	height:26px;
	display:inline-block;
	background:url("/images/site/log-out.png") no-repeat;
	background-size: 26px 26px;
}
.pageavailable-icon {
	width:30px;
	height:26px;
	display:inline-block;
	background:url("/images/site/pageavailable-icon.png") no-repeat;
	background-size: 30px 26px;
}
.pageavaudit-icon {
	width:26px;
	height:26px;
	display:inline-block;
	background:url("/images/site/pageavaudit-icon.png") no-repeat;
	background-size: 26px 26px;
}
.pageback-icon {
	width:30px;
	height:26px;
	display:inline-block;
	background:url("/images/site/arrow-back.png") no-repeat;
	background-size: 16px 26px;
}
.banner-text {
	background:<?=$color2?>;
	text-shadow:none;
	text-align:center;
	color:#fff;
	padding:13px 22px;
	margin:0 0 20px;
}
.banner-text h3 {
	font-family: 'latobold';
	font-size:35px;
	margin:10px 0;
}
.banner-text p {
	font-family: 'latolight';
	font-size:24px;
	margin:10px 0;
}
.content-bgshadow {
	background:#ffffff;
	box-shadow: 0px 2px 2px #cdcdcd;
	-webkit-box-shadow: 0px 2px 2px #cdcdcd;
	-moz-box-shadow: 0px 2px 2px #cdcdcd;
	padding-bottom:50px;
}
.greenbtn {
	display:block;
	text-align:center;
	padding:20px 0;
	/*background:url("/images/site/btn-bg.png") repeat-x <?=$color4?>;*/
    background: <?=$color4?>;
	color:#FFF !important;
	text-shadow:none;
	text-decoration:none;
	font-size:30px;
	text-transform:uppercase;
    font-weight: 700;
    height: 30px;
}
.greenbtn:visited {
	color:#FFF !important;
	text-shadow:none;
	text-decoration:none;
}
.greenbtn input {
	background: transparent none repeat scroll 0 0 !important;
    color: transparent !important;
    height: 59px;
    margin-top: -58px;
    opacity: 0;
    position: absolute;
    z-index: 1;
}
.greenbtn .ui-input-text {
	background:transparent!important;
	border:none!important;
	box-shadow: none!important;
	-webkit-box-shadow:none!important;
	-moz-box-shadow:none!important;
}
.camicon {
	display:inline-block;
	height:22px;
	width:22px;
	margin: 0 5px 0 0;
	background: url("/images/site/camera-icon.png") no-repeat;
	background-size: 22px 22px;
}
.galphotoicon {
	display:inline-block;
	height:22px;
	width:22px;
	margin: 0 5px 0 0;
	background: url("/images/site/gallery-icon.png") no-repeat;
	background-size: 22px 22px;
}
.camphoticon {
	display:inline-block;
	height:22px;
	width:22px;
	margin: 0 5px 0 0;
	background: url("/images/site/current-pic-icon.png") no-repeat;
	background-size: 22px 22px;
}


.campopwidth {
	max-width:320px;
	text-align:center;
	font-family: 'latobold';
	font-size:30px;
	padding: 20px 0;
}
.campopwidth a {
	color:#15addd !important;
	display:block;
	text-decoration:none;
}

/*----- changes 01.06 start-----*/
.feedback-success {
	background:#6f8e26;
	margin:15px 0;
	padding: 20px;
	font-family: 'latolight';
	font-size: 24px;
	margin: 10px 0;
}
.feedback-success h3 {
	font-family: 'latobold';
	font-size: 35px;
	margin: 0px 0 10px 0;
}
.feedback-success ul {
	margin:0;
	padding:0;
	text-shadow:none;
	color:#fff;
}
.feedback-success ul li {
	margin:0;
	padding:0;
	text-shadow:none;
	color:#fff;
	list-style:none;
}
.feedback-fail {
    background: #ff0000 none repeat scroll 0 0;
    font-family: "latolight";
    font-size: 18px;
    margin: 10px 0;
    padding: 10px;
}
.feedback-fail h3 {
    font-family: "latobold";
    font-size: 24px;
    margin: 0;
}
.feedback-fail ul {
	margin:0;
	padding:0;
	text-shadow:none;
	color:#fff;
}
.feedback-fail ul li {
	margin:0;
	padding:0;
	text-shadow:none;
	color:#fff;
	list-style:none;
}


.photogall {
	overflow:hidden;
	position:relative;
	height: 20px;
}
.photogall .ui-input-text {
	background:transparent!important;
	border:none!important;
	box-shadow: none!important;
	-webkit-box-shadow:none!important;
	-moz-box-shadow:none!important;
}
.photogall input {
	background:transparent!important;
	color:transparent!important;
	opacity:0;
}
.photogall span {
	position:absolute;
	width: 100%;
	text-align: center;
	display: block;
	line-height: 20px;
	color: #15addd;
	font-family: 'latoregular';
	font-size: 18px;
	font-weight: bold;
}


/*----- changes 01.06 start-----*/

textarea {
	height: auto !important; /* !important is used to force override. */
}
.ui-body-a, html .ui-panel-page-container-a {
	font-family: 'latoregular';
	font-size:18px;
	text-shadow:none;
	color:#fff;
	background:<?=$color2?>;
	border: #f5f5f5 2px solid;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}
/*------------------------  #splash page -----------------------*/
.splashbg {
	/*background:url("/images/site/splashbg.jpg") repeat-x #015a7e;*/
    background: <?=$color2?>;
	height:100%;
}
.splash {
	height:100%;
	display:block;
	text-align:center;
	position:relative !important;
	margin:3% 0 0 0;
}
.splashbg img {
	max-width:100%;
	max-height:100%;
	position:absolute;
	bottom:0;
	left:0;
	right:0;
	margin:auto;
}
/*------------------------  #home page -----------------------*/
.homebg {
	/*background:url("/images/site/splashbg.jpg") repeat-x #015a7e;*/
    background: <?=$color2?>;
}
.homebg .navbar {
	font-family: 'bree_ltlight';
	font-size:33px;
}
.homebg .navbar .ui-block-a {
	width: 33.333%;
}
.homebg .navbar .ui-block-b {
	width: 33.333%;
}
.homeiconholder {
	text-align:center;
}
.homeiconholder ul {
	text-align:center;
	margin-top:70px;
	padding:0;
}
.homeiconholder ul li {
	vertical-align: top;
	margin:0 40px;
	text-align:center;
	display:inline-block;
	width:177px;
	height:auto;
	background:url("/images/site/homeicon-shadow.png") 20px 20px no-repeat;
	background-size: 177px;
}
.homeiconholder ul li a:after {
	content: "";
	background:url("/images/site/homeicon-curl.png") no-repeat;
	background-size: 43px 47px;
	width:43px;
	height:47px;
	position:absolute;
	bottom:13px;
	right:13px;
}
.homeiconholder ul li a {
	position:relative;
	background:url("/images/site/homeicon-holder.png") no-repeat;
	background-size: 135px 135px;
	display: inline-block;
	width: 135px;
	height: 135px;
	line-height: 135px;
	/*margin: 21px 0 0 14px;*/
  text-align:center;
}
.homeiconholder ul li a img {
	vertical-align:middle;
}
.homeiconholder ul li span {
	font-family: 'bree_ltlight';
	font-size:25px;
	display: block;
	padding:26px 0px 0 0px;
	text-shadow:none;
	text-align:center;
	color:#fff;
}
.homecontent {
	padding: .4em 0em;
}
/*------------------------  available audit page -----------------------*/
.region-items {
	padding:3px 0;
}
.region-items ul {
	margin:0;
	padding:0;
}
.region-items li {
	list-style:none;
	margin:0;
	padding:0;
	position: relative;
	display:block;
	background:#fff;
	padding: 20px;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	box-shadow: 0px 2px 2px #cdcdcd;
	-webkit-box-shadow: 0px 2px 2px #cdcdcd;
	-moz-box-shadow: 0px 2px 2px #cdcdcd;
	border-radius:3px;
	-webkit-border-radius:3px;
	-moz-border-radius:3px;
	margin:12px 14px 0 14px;
}
.region-right {
	float: right;
	width:15px;
	height:26px;
	display:inline-block;
	background:url("/images/site/region-arrow.png");
	line-height: 20px;
	margin:3px 0 0 0;
}
.region-items .region-info {
	margin-left: 0px;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	color:<?=$color4?>;
	font-family: 'latoregular';
	font-size:26px;
	text-decoration: none;
	display:block;
	background:url("/images/site/region-arrow.png") no-repeat right;
}
.region-items .region-info:visited {
	color:<?=$color4?>;
}
.region-items .region-info p {
	margin:0px 0;
}
.available-items {
	padding:3px 0;
}
.available-items ul {
	margin:0;
	padding:0;
}
.available-items li {
	list-style:none;
	margin:0;
	padding:0;
	position: relative;
	float: left;
	width: 100%;
	border-bottom: 1px solid #dadada;
	padding: 0 10px 10px 10px;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}
.available-items h3 {
	color:#15a8d8;
	font-family: 'latoregular';
	font-size:20px;
	text-transform: uppercase;
}
.available-items .thumbnail {
	float: left;
	vertical-align: middle;
	margin-right: 10px;
	margin-bottom: 10px;
	max-width: 226px;
	background:#f5f5f5;
	text-align:center;
	box-shadow: 0px 2px 2px #cdcdcd;
	-webkit-box-shadow: 0px 2px 2px #cdcdcd;
	-moz-box-shadow: 0px 2px 2px #cdcdcd;
	border-radius:3px;
	-webkit-border-radius:3px;
	-moz-border-radius:3px;
}
.available-items .thumbnail:after {
	content: "";
	background:url("/images/site/iconholder-arrow.png") no-repeat;
	width:10px;
	height:12px;
	position:absolute;
	top:5px;
	right:-8px;
}
.available-items .thumbnail img {
	vertical-align: middle;
    max-width: 150px;
}
.available-items .status-right {
	float: right;
	width:28px;
	height:22px;
	display:inline-block;
	background:url("/images/site/availableicon-right.png") no-repeat;
	line-height: 20px;
}
.available-items .info-right {
	float: right;
	width:15px;
	height:26px;
	display:inline-block;
	background:url("/images/site/item-arrow.png");
	line-height: 20px;
}
.available-items .info {
	margin-left: 136px;
	padding-right: 35px;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;/*----- changes 01.06 start-----*/
   /*----- background:url("/images/site/availableicon-right.png") 100% 50% no-repeat; -----*/
   /*----- changes 01.06 end-----*/
  
}
/*----- changes 01.06 start-----*/
.availableaudit-radio {
	float:right;
}
.single-radioicon label {
	padding:40px 20px;
}

/*----- changes 01.06 end-----*/

.available-items h4 {
	color:<?=$color4?>;
	text-transform: uppercase;
	font-family: 'latoblack';
	font-size:24px;
	margin:0;
}
.available-items p {
	color:#016e94;
	margin:0;
	font-family: 'latoregular';
	font-size:23px;
}
/*------------------------ Active page -----------------------*/

.active-items {
	padding:3px 0;
}
.active-items ul {
	margin:0;
	padding:0;
}
.active-items li {
	list-style:none;
	margin:0;
	padding:0;
	position: relative;
	float: left;
	width: 100%;
	border-bottom: 1px solid #dadada;
	padding:30px 10px;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}
.active-items .link-heading {
	margin:0 0 26px 0;
	color:#15a8d8;
	font-family: 'latoregular';
	font-size:20px;
	text-transform: uppercase;
	display:block;
}
.active-items .thumbnail {
	position:relative;
	float: left;
	vertical-align: middle;
	margin-right: 10px;
	margin-bottom: 10px;
	max-width: 200px;
	max-height: 110px;
	background:#f5f5f5;
	text-align:center;
	box-shadow: 0px 2px 2px #cdcdcd;
	-webkit-box-shadow: 0px 2px 2px #cdcdcd;
	-moz-box-shadow: 0px 2px 2px #cdcdcd;
	border-radius:3px;
	-webkit-border-radius:3px;
	-moz-border-radius:3px;
}
.active-items .thumbnail:after {
	content: "";
	background:url("/images/site/iconholder-arrow.png") no-repeat;
	width:10px;
	height:12px;
	position:absolute;
	top:5px;
	right:-8px;
}
.active-items .thumbnail img {
	vertical-align: middle;
     max-width: 150px;
	max-height: 110px;
}
.active-items .info {
	margin-left: 136px;
	padding-right: 35px;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	display:block;
	display:block;
	background:url("/images/site/item-arrow.png") 100% 50% no-repeat;
}
.activelink-heading {
	color:<?=$color4?>;
	text-transform: uppercase;
	font-family: 'latoblack';
	font-size:24px;
	margin:0;
	display:block;
	padding:0 0 10px 0;
}
.active-items a {
	text-decoration:none;
}
.activelink-address {
	color:#016e94;
	margin:0;
	font-family: 'latoregular';
	font-size:23px;
}
/*------------------------ #auditsection -----------------------*/
.auditsectionbg {
}
.auditsectionbg .navbar {
	font-family: 'latobold';
	font-size:33px;
}
.auditsectionbg .navbar .ui-block-a, .auditsectionbg .navbar .ui-block-c {
	width:15%;
}
.auditsectionbg .navbar .ui-block-b {
	width:70%;
}
.pagethumb {
	text-align:center;
}
.pagethumb ul {
	text-align:center;
	margin:10px 0;
	padding:0;
}
.pagethumb ul li {
	position:relative;
	vertical-align: top;
	display:inline-block;
}
.pagethumb .thumbnail {
	position:relative;
	float: left;
	vertical-align: middle;
	margin-right: 10px;
	margin-bottom: 10px;
	width: auto;
	background:#f5f5f5;
	text-align:center;
	box-shadow: 0px 2px 2px #cdcdcd;
	-webkit-box-shadow: 0px 2px 2px #cdcdcd;
	-moz-box-shadow: 0px 2px 2px #cdcdcd;
	border-radius:3px;
	-webkit-border-radius:3px;
	-moz-border-radius:3px;
}
.pagethumb .thumbnail img {
	vertical-align: middle;
}
.pagethumb .thumbnail:after {
	content: "";
	background:url("/images/site/iconholder-arrow.png") no-repeat;
	width:10px;
	height:12px;
	position:absolute;
	top:5px;
	right:-8px;
}
.auditsectioncontent {
	text-align:center;
}
.auditsectioncontent h2 {
	font-family: 'latoblack';
	font-size:28px;
	color:<?=$color4?>;
}
.auditsectioncontent h3 {
	font-family: 'latoblack';
	font-size:30px;
	color:#016e94;
}
.auditsectioncontent p {
	font-family: 'latoregular';
	color:#016e94;
	font-size:27px;
}
.auditsection-iconset {
	text-align:center;
}
.auditsection-iconset ul {
	margin:10px 0;
	padding:0;
}
.auditsection-iconset ul li {
	display:inline-block;
	margin: 0 10px;
}
/*----- changes 01.06 start-----*/
.location-icon {
	width:55px;
	height:55px;
	display:inline-block;
	background:url("/images/site/location-icon.png") no-repeat;
	background-size: 55px 55px;
}
.phone-icon {
	width:55px;
	height:55px;
	display:inline-block;
	background:url("/images/site/phone-icon.png") no-repeat;
	background-size: 55px 55px;
}
.start-icon {
	width:55px;
	height:55px;
	display:inline-block;
	background:url("/images/site/start-icon.png") no-repeat;
	background-size: 55px 55px;
}
.cancel-icon {
	width:55px;
	height:55px;
	display:inline-block;
	background:url("/images/site/cancel-icon.png") no-repeat;
	background-size: 55px 55px;
}
/*----- changes 01.06 end-----*/
.auditsection-grid {
	padding:24px 0;
	color:#016e94;
	font-family: 'latolight';
	font-size:25px;
	text-align:left;
}
.auditsection-grid p {
	padding:0 0 0 20px;
}
.auditsection-grid b {
	font-family: 'latobold';
	font-size:27px;
}
.auditsection-grid div:first-child {
	border-left:none;
}
.auditsection-grid div {
	border-left:1px solid #e1e1e1;
	pading:20px 0;
}
.auditsection-hr {
	border: 0;
	height: 1px;
	background: #e1e1e1;
}
.auditsection-description {
	font-family: 'latoregular';
	text-align:left;
	font-size:24px;
	color:#187393;
}
.auditsection-description b {
	font-size:27px;
	color:<?=$color4?>;
}
/*------------------------ #audit -----------------------*/

.banner-grid {
}
.banner-grid .ui-block-a, .banner-grid .ui-block-c {
	width:20%;
}
.banner-grid .ui-block-b {
	width:60%;
}
.qback {
	margin:30px 0 0 0;
	width:37px;
	height:30px;
	display:inline-block;
	background:url("/images/site/qarrow-left.png") no-repeat;
	background-size: 37px 30px;
}
.qnext {
	margin:30px 0 0 0;
	width:37px;
	height:30px;
	display:inline-block;
	background:url("/images/site/qarrow-right.png") no-repeat;
	background-size: 37px 30px;
}
.content-sqicon .ui-icon-calendar:after {
	background: url("/images/site/calender-icon.png") no-repeat;
	background-size: 22px 22px;
}
.content-sqicon .ui-icon-clock:after {
	background: url("/images/site/timepicker-icon.png") no-repeat;
	background-size: 22px 22px;
}
.content-datetime .ui-field-contain, .content-datetime .ui-mobile fieldset.ui-field-contain {
	border:none;
}
.content-datetime .ui-field-contain>label, .content-datetime .ui-field-contain .ui-controlgroup-label, .ui-field-contain>.ui-rangeslider>label {
	color:#16b8e9;
}
.content-datetime .ui-field-contain:after, .content-datetime .ui-mobile fieldset.ui-field-contain:after {
	content:"";
	display:block;
	visibility:hidden;
	clear:both;
	height:0;
}
.content-sqicon .ui-btn-icon-left:after, .content-sqicon .ui-btn-icon-right:after, .content-sqicon .ui-btn-icon-top:after, .content-sqicon .ui-btn-icon-bottom:after, .content-sqicon .ui-btn-icon-notext:after {
	border-radius: 0;
	-webkit-border-radius: 0;
	-moz-border-radius: 0;
}
.content-radioicon .ui-mini.ui-btn-icon-left:after, .content-radioicon .ui-mini .ui-btn-icon-left:after, .content-radioicon .ui-header .ui-btn-icon-left:after, .content-radioicon .ui-footer .ui-btn-icon-left:after {
	background: url("/images/site/radioicon.png") no-repeat;
	background-size: 26px 26px;
	/* background-image: none; */
  /* background-color: #fff; */
  border:none;
	width: 26px;
	height: 26px;
	opacity: 1;
}
.content-radioicon .ui-radio .ui-btn.ui-radio-on:after {
	background: url("/images/site/radioicon-selected.png") no-repeat;
	background-size: 26px 26px;
	/* background-image: none; */
  /* background-color: #fff; */
  width: 26px;
	height: 26px;
	/*border-width: 0px;
  border-style: solid;*/
  border:none;
}
.content-radioicon .ui-icon-check:after, .content-radioicon .ui-btn.ui-checkbox-on.ui-checkbox-on:after {
	background: url("/images/site/radioicon-selected.png") no-repeat;
	background-size: 26px 26px;
	/* background-image: none; */
  /* background-color: #fff; */
  width: 26px;
	height: 26px;
	/*border-width: 0px;
  border-style: solid;*/
  border:none;
}
.content-radioicon label.ui-btn.ui-corner-all.ui-btn-inherit.ui-btn-icon-left.ui-radio-on {
	background:#FFF;
	border:none;
}
.content-radioicon .ui-checkbox .ui-btn, .content-radioicon .ui-radio .ui-btn {
	background:#FFF;
	border:none;
	color:#15addd;
	font-family: 'latoregular';
	font-size:28px;
}
.auditsection-description p {
	margin:0 30px 0 0;
}
.note {
	float:right;
	background: url("/images/site/note-icon.png") no-repeat;
	background-size: 26px 26px;
	height:26px;
	width:26px;
	display:block
}

.check {
	float:right;
	background: url("/images/site/check-icon.png") no-repeat;
	background-size: 26px 26px;
	height:26px;
	width:26px;
	display:block
}

.custom-copllapse .ui-btn, .custom-copllapse .ui-bar-a .ui-btn, .custom-copllapse .ui-body-a .ui-btn, .custom-copllapse .ui-btn, .custom-copllapse .ui-btn.ui-btn-a, .custom-copllapse .ui-btn:visited, .custom-copllapse .ui-btn:visited, .custom-copllapse .ui-btn:visited, .custom-copllapse:visited {
    background:none;
    border:none;
    color:#15addd;
    font-size:18px;
    font-family: 'latobold';
}
.custom-copllapse .ui-body-inherit {
	color:#15addd;
}
.custom-copllapse .ui-collapsible-content {
	background:#f5f5f5;
}
.custom-copllapse .ui-body-inherit, .custom-copllapse .ui-bar-a .ui-body-inherit, .custom-copllapse .ui-body-a .ui-body-inherit, .custom-copllapse .ui-group-theme-a .ui-body-inherit, .custom-copllapse .ui-panel-page-container-a {
	background:none;
	border:none;
}
 .custom-copllapse .ui-collapsible-content>.ui-listview:not(.ui-listview-inset) {
 -webkit-border-radius: inherit;
 border-radius: inherit;
 background-color: #f5f5f5;
 color:#15addd;
 font-size:28px;
 font-family: 'latoregular';
}
.customtextbox .ui-body-a, .customtextbox .ui-body-inherit, .customtextbox .ui-bar-a .ui-body-inherit, .customtextbox .ui-body-a .ui-body-inherit, .customtextbox .ui-body-inherit, .customtextbox .ui-panel-page-container-a {
	background:#f5f5f5;
}
/*------------------------ #auditsectionquestions -----------------------*/
.auditsectionquestions-content {
	padding:10px 0;
}
.auditsectionquestions .navbar {
	font-family: 'latobold';
	font-size:33px;
}
.auditsectionquestions .navbar .ui-block-a, .auditsectionquestions .navbar .ui-block-c {
	width:15%;
}
.auditsectionquestions .navbar .ui-block-b {
	width:70%;
}
.auditsectionquestions-content p {
	text-align:center;
	font-family: 'latolight';
	color:#187393;
	font-size:26px;
}
.auditsectionquestions-content span {
	color:<?=$color4?>;
}
.auditsectionquestionsholder {
	text-align:center;
}
.auditsectionquestionsholder ul {
	text-align:center;
	margin:70px 0 0 0;
	padding:0;
}
.auditsectionquestionsholder ul li {
	margin:0 50px;
	vertical-align: top;
	text-align:center;
	display:inline-block;
	width:144px;
	background:url("/images/site/homeicon-shadow.png") 20px 20px no-repeat;
	background-size: 144px;
}
.auditsectionquestionsholder ul li a {
	position:relative;
	background:url("/images/site/homeicon-holder.png") no-repeat;
	background-size: 116px 116px;
	display: inline-block;
	width: 116px;
	height: 116px;
	line-height: 116px;
	/* margin: 20px 0 0 13px;*/
  text-align:center;
}
.auditsectionquestionsholder ul li a img {
	vertical-align:middle;
}
.auditsectionquestionsholder ul li span {
	font-family: 'latobold';
	font-size:20px;
	display: block;
	padding:26px 0 0 0;
	text-shadow:none;
	text-align:center;
	color:#016e94;
}
.auditsectionquestionsholder ul li p {
	background:#e83737;
	height:40px;
	line-height:40px;
	width:40px;
	display:block;
	position:absolute;
	top:-10px;
	left:90px;
	padding:0;
	margin:0;
	font-family: 'bree_ltlight';
	font-size:24px;
	text-align:center;
	color:#fff;
	border-radius:40px;
	-webkit-border-radius:40px;
	-moz-border-radius:40px;
}
/*------------------------ #thankyou -----------------------*/
.thankyou .navbar {
	font-family: 'latobold';
	font-size:33px;
}
.thankyou .navbar .ui-block-a, .thankyou .navbar .ui-block-c {
	width:15%;
}
.thankyou .navbar .ui-block-b {
	width:70%;
}
.homebody {
	text-align:center;
	height:100%;
	padding:10% 0 0 0;
}
.homebody p {
	font-family: 'latoregular';
	color:#80a63a;
	font-size:30px;
}
.homebody b {
	font-family: 'latobold';
	color:#15addd;
	font-size:52px;
	display:block;
	padding:0 0 20px 0;
}
.homebody span {
	font-family: 'latobold';
	color:<?=$color1?>;
	font-size:49px;
	display:block;
	padding:0 0 20px 0;
}
/*------------------------ #thankyou -----------------------*/
.content-login {
	padding: 20px 0;
	margin: 30px 0;
}



/* stack all grids below 40em (640px) */
@media all and (max-width: 35em) {
 .greenbtn {
font-size:18px;
}
 .banner-text h3 {
 font-size: 24px;
}
 .banner-text p {
font-size: 18px;
}
.feedback-success h3{
 font-size: 24px;
}
.feedback-success p {
font-size: 18px;
}
.feedback-fail  h3{
 font-size: 24px;
}
.feedback-fail  p {
font-size: 18px;
}

    /*------------------------  #home  -----------------------*/
	    .homeiconholder ul li {
margin:0 0px;
}
 .homebg .navbar {
 font-size: 28px;
}
 .homeiconholder ul li span {
 font-size: 22px;
}
	/*------------------------  #availableaudit  -----------------------*/	
		.region-items .region-info {
font-size: 18px;
}
		
	/*------------------------  #availableauditinner  -----------------------*/
        .available-items h3 {
font-size: 16px;
}
 .available-items h4 {
font-size: 18px;
}
 .available-items p {
font-size: 17px;
}
		
	/*------------------------  #activeaudit  -----------------------*/
	    .active-items .link-heading {
font-size: 16px;
}
 .activelink-heading {
font-size: 18px;
}
 .activelink-address {
font-size: 17px;
}
		
		

         /*------------------------ #auditsection -----------------------*/
		 .auditsectionbg .navbar {
 font-size: 24px;
}
 .auditsectioncontent h2 {
 font-size: 18px;
}
.auditsectioncontent p {
 font-size: 16px;
}
 .auditsectioncontent h3 {
 font-size: 26px;
}
 .auditsection-grid {
 font-size: 13px;
}
 .auditsection-grid b {
 font-size: 14px;
}
 .auditsection-description {
 font-size: 18px;
}
.auditsection-description b {
 font-size: 19px;
}
	
	
	/*------------------------ #audit -----------------------*/
	
	/*------------------------ #auditq0 -----------------------*/
	
	.content-radioicon .ui-checkbox .ui-btn, .content-radioicon .ui-radio .ui-btn {
font-size:18px;
}
	
	/*------------------------ #auditq1 -----------------------*/
	
	
	
	
	.content-datetime .ui-field-contain>label, .content-datetime .ui-field-contain .ui-controlgroup-label, .ui-field-contain>.ui-rangeslider>label {
 float: left;
 width: 20%;
 margin: .5em 2% 0 0;
}
 .content-datetime .ui-field-contain>label~[class*=ui-], .content-datetime .ui-field-contain .ui-controlgroup-controls {
 float: left;
 width: 78%;
 -webkit-box-sizing: border-box;
 -moz-box-sizing: border-box;
 box-sizing: border-box;
}
	
	
		/*------------------------ #auditq3 -----------------------*/
		.custom-copllapse .ui-btn, .custom-copllapse .ui-bar-a .ui-btn, .custom-copllapse .ui-body-a .ui-btn, .custom-copllapse .ui-btn, .custom-copllapse .ui-btn.ui-btn-a, .custom-copllapse .ui-btn:visited, .custom-copllapse .ui-btn:visited, .custom-copllapse .ui-btn:visited, .custom-copllapse:visited {
 font-size:18px;
}
.custom-copllapse .ui-collapsible-content>.ui-listview:not(.ui-listview-inset) {
 font-size:16px;
}
	
	/*------------------------ #auditsectionquestions -----------------------*/
.auditsectionquestions .navbar {
 font-size: 24px;
}
.auditsectionquestions-content p {
 font-size: 16px;
}
.auditsectionquestionsholder ul li span {
font-size:16px;
}
.auditsectionquestionsholder ul li {
margin:0;
}
	
	/*------------------------ #thankyou -----------------------*/
	
.thankyou .navbar {
 font-size: 24px;
}
 .homebody b {
 font-size: 26px;
}
 .homebody span {
 font-size: 24px;
}
.homebody p {
 font-size: 15px;
}
}

@media all and (max-width: 776px) {
		.ui-block-a {
			font-size: 90%;
		}
	}
	
@media all and (max-width: 370px) {
	.ui-block-a {
		font-size: 50%;
	}
    .homeiconholder ul li {
		width: 45%;
	  }
	.homeiconholder ul li {
		  width: 104px;
		  background: url("/images/site/homeicon-shadow.png") -6px 0px no-repeat;
		  background-size: 134px;
		}
	.homeiconholder ul li a {
		  background-size: 90px 90px;
		  width: 104px;
		  height: 103px;
		  line-height: 80px;
		}
	.homeiconholder ul li a img {
		  vertical-align: middle;
		  width: 40%;
		  margin-left: -18px;
		  margin-top: 11px;
		}
	.homeiconholder ul li span{
		  padding: 0px 0px 0 0px;
		  font-size: 14px;
	}
    .homeiconholder ul li a:after{
		background-size: 32px 36px;
		width: 41px;
	}
	
	.auditsectionquestionsholder ul li {
		width: 45%;
	  }
	.auditsectionquestionsholder ul li {
		  width: 104px;
		  background: url("/images/site/homeicon-shadow.png") -6px 0px no-repeat;
		  background-size: 134px;
		}
	.auditsectionquestionsholder ul li a {
		  background-size: 90px 90px;
		  width: 104px;
		  height: 103px;
		  line-height: 80px;
		}
	.auditsectionquestionsholder ul li a img {
		  vertical-align: middle;
		  width: 40%;
		  margin-left: -18px;
		  margin-top: 11px;
		}
	.auditsectionquestionsholder ul li span{
		  padding: 0px 0px 0 0px;
		  font-size: 14px;
	}
    	.auditsectionquestionsholder ul li a:after{
		background-size: 32px 36px;
		width: 41px;
	}
	.auditsectionquestionsholder ul li p {
		background: #e83737 none repeat scroll 0 0;
		border-radius: 71px;
		color: #fff;
		display: block;
		font-family: "bree_ltlight";
		font-size: 14px;
		height: 30px;
		left: 71px;
		line-height: 30px;
		margin: 0;
		padding: 0;
		position: absolute;
		text-align: center;
		top: -10px;
		width: 26px;
	}
	.auditsectionquestionsholder ul {
		margin: 44px 0 0;
	}
}

.auditselectli:hover{
    background: #f9f9f9 none repeat scroll 0 0;
    cursor: pointer;
}

.ui-input-text input, .ui-input-search input, textarea.ui-input-text {
    line-height: 0.8em !important;
}
.content-bgshadow {
   margin-bottom: 15px !important;
}

.greenbtn {
    background: <?=$color4?> none repeat scroll 0 0;
    color: #fff !important;
    display: block;
    font-size: 15px;
    font-weight: 700;
    height: 22px;
    padding: 16px 0;
    text-align: center;
    text-decoration: none;
    text-shadow: none;
    text-transform: uppercase;
}
.content-radioicon .ui-checkbox .ui-btn, .content-radioicon .ui-radio .ui-btn {
    font-size: 20px !important;
}
.ui-btn, label.ui-btn{
	font-weight: normal !important;
	}
.ui-page-theme-a a, html .ui-bar-a a, html .ui-body-a a, html body .ui-group-theme-a a {
    text-decoration: none !important;
}
.client_logo{
	width:auto !important;
	}
@media (max-width:560px){
  .banner-text p {
		font-size: 14px;
	}

	.content-radioicon .ui-radio .ui-btn.ui-radio-on::after {
		background: rgba(0, 0, 0, 0) url("/images/site/radioicon-selected.png") no-repeat scroll 0 0 / 18px 18px;
		height: 18px;
	}
	.content-radioicon .ui-mini.ui-btn-icon-left::after, .content-radioicon .ui-mini .ui-btn-icon-left::after, .content-radioicon .ui-header .ui-btn-icon-left::after, .content-radioicon .ui-footer .ui-btn-icon-left::after {
    background: rgba(0, 0, 0, 0) url("/images/site/radioicon.png") no-repeat scroll 0 0 / 18px 18px;
    height: 18px;
    }
    .content-radioicon .ui-radio .ui-btn.ui-radio-on::after {
		background: rgba(0, 0, 0, 0) url("/images/site/radioicon-selected.png") no-repeat scroll 0 0 / 18px 18px;
		height: 18px;
	}
	.content-radioicon .ui-checkbox .ui-btn, .content-radioicon .ui-radio .ui-btn {
		font-size: 16px;
	}

	.ui-input-text input, .ui-input-search input, textarea.ui-input-text {
		line-height: 0.4em;
	}
	.content-bgshadow {
		margin-bottom: 0;
	}
	.content-bgshadow {
	    padding-bottom: 5px;
	}
	.content-radioicon .ui-checkbox .ui-btn, .content-radioicon .ui-radio .ui-btn {
    font-size: 12px;
	}
	.banner-text p {
		margin: 10px 0 !important;
	}
	.galphotoicon {
		background: rgba(0, 0, 0, 0) url("/images/site/gallery-icon.png") no-repeat scroll 0 0 / 18px 18px;
		height: 16px;
    }
    .greenbtn {
		font-size: 12px;
	}
	textarea.ui-input-text.ui-textinput-autogrow {
    font-size: 13px;
    line-height: 15px;
    height: 60px !important;
    }
   .content-radioicon .ui-icon-check::after, .content-radioicon .ui-btn.ui-checkbox-on.ui-checkbox-on::after {
    background: rgba(0, 0, 0, 0) url("/images/site/radioicon-selected.png") no-repeat scroll 0 0 / 18px 18px;
    height: 18px;
   }
}

@media (max-width:500px){
	.active-items .thumbnail{
		max-width: 125px;
	}
	.activelink-heading {
		font-size: 12px;
		font-weight: normal;
	}

	.activelink-address {
		font-size: 12px;
		font-weight: normal;
	}
	.active-items .link-heading {
		font-size: 14px;
	}
	.active-items .thumbnail img{
		max-width: 100%;
	}
}
@media (max-width:300px){
	.pagethumb .thumbnail img {
		width: 100%;
	}
	.auditsectioncontent h3 {
    font-size: 20px;
	}
	.start-icon{
		background-size: 55px 55px !important;
	}
	.auditsection-grid b {
		font-size: 11px;
		font-weight: normal;
	}
	.auditsectioncontent p {
		font-size: 12px;
	}
	.auditsection-description b {
    font-size: 14px;
    font-weight: normal;
	}
}

span.greenbtn.red {
  background-color: rgb(234, 79, 79) !important;
}
