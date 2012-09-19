<?php

//Set page starter variables//
$cookieValid	= false;
$activeMiners = false;
 ini_set("display_errors", 1);
require("includes/requiredFunctions.php");
require("includes/universalChecklogin.php");
include ("includes/templates/btceapi.php");
include ("includes/templates/btcapi.php");
if (!isset($pageTitle)) $pageTitle = outputPageTitle();
else $pageTitle = outputPageTitle(). " ". $pageTitle;

?>
<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title><?php echo $pageTitle;?></title>

        <meta http-equiv="X-UA-Compatible" content="IE=7" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
	<link rel="stylesheet" href="css/mainstyle.css" type="text/css" />
	<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="js/jquery.tools.min.js"></script>

        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/jquery.img.preload.js"></script>
        <script type="text/javascript" src="js/jquery.filestyle.mini.js"></script>
        <script type="text/javascript" src="js/jquery.wysiwyg.js"></script>
        <script type="text/javascript" src="js/jquery.date_input.pack.js"></script>
        <script type="text/javascript" src="js/facebox.js"></script>
        <script type="text/javascript" src="js/jquery.visualize.js"></script>
        <script type="text/javascript" src="js/jquery.visualize.tooltip.js"></script>
        <script type="text/javascript" src="js/jquery.select_skin.js"></script>
        <script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
        <script type="text/javascript" src="js/ajaxupload.js"></script>
        <script type="text/javascript" src="js/jquery.pngfix.js"></script>
        <script type="text/javascript" src="js/custom.js"></script>

        <!--[if IE]><script type="text/javascript" src="js/excanvas.js"></script><![endif]-->

	<?php
		//If user isn't logged in load the login.js
		if (!$cookieValid) {
	?>
		<script src="/js/login.js"></script>
	<?php } ?>

	    <style type="text/css" media="all">
                @import url("css/style.css");
                @import url("css/jquery.wysiwyg.css");
                @import url("css/facebox.css");
                @import url("css/visualize.css");
                @import url("css/date_input.css");
	    </style>

	<!--[if lt IE 8]><style type="text/css" media="all">@import url("css/ie.css");</style><![endif]-->

</head>

<body>
<div id="hld">
<div class="wrapper">

<div id="siteheader">

    <div id="siteinfo">
	<?php if (isset($pageTitle)) { print $pageTitle; } ?>
	<br>
	<span class="slogan"><?php print $settings->getsetting('slogan'); ?></span>
    </div>
    <div id="ministats">
	<table border="0">
	<tr>
    <td><li>ltc/usd: $<?php echo "$ltcusd"?> &nbsp;&nbsp;&nbsp;&nbsp;</li></td>
    <td><li>ltc/btc: <?php echo "$ltcbtc"?> &nbsp;&nbsp;&nbsp;&nbsp;</li></td>
	<td><li>btc/usd: $<?php print $settings->getsetting('mtgoxlast'); ?>&nbsp;&nbsp;&nbsp;&nbsp;</li></td>
	<td><li>Pool Hashrate: <?php print round($settings->getsetting('currenthashrate')/1, 2); ?> KH/s&nbsp;&nbsp;&nbsp;&nbsp;</li></td>
    <?
    $res = mysql_query("SELECT count(webUsers.id) FROM webUsers WHERE hashrate > 0") or sqlerr(__FILE__, __LINE__);
    $row = mysql_fetch_array($res);
    $users = $row[0];
    ?>
    <td><li>Pool Miners: <?php print  number_format($users) ;?> &nbsp;&nbsp;&nbsp;&nbsp;</li></td>
	<td><li>Pool Workers: <?php print $settings->getsetting('currentworkers'); ?>&nbsp;&nbsp;&nbsp;&nbsp;</li></td>
	</tr>
	</table>
    </div>

</div>


<?php include ("includes/templates/menu.php"); ?>
<?php //include ("includes/leftsidebar.php"); ?>


