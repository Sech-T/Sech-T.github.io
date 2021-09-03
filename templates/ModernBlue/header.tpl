<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$settings.site_title}</title>
<link href="./templates/ModernBlue/css/global.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./js/jquery.min.js"></script>
<script type="text/javascript" src="./js/jquery-ui-1.9.1.custom.min.js"></script>
<link href="./templates/ModernBlue/css/evolutionscript/jquery-ui-1.9.2.custom.css" rel="stylesheet">
<script type="text/javascript" src="./js/evolutionscript.js"></script>
<script type="text/javascript" src="js/l2blockit.js"></script>
<script>
$(function(){
	$(".navbar .submenu").hover(function(){
		$(this).children('ul').show();
	}, function(){
		$(this).children('ul').hide();
	});
{if $logged == 'yes'}
	var stickyNavTop = $('.flotator').offset().top;  	
	stickyNavTop= stickyNavTop+130;
	var stickyNav = function(){  
	var scrollTop = $(window).scrollTop();  		   
	if (scrollTop > (stickyNavTop)) { 
		$('.member_toolbar').show();  
		$('.flotator').addClass('sticky');  
	} else {  
		$('.member_toolbar').hide();
		$('.flotator').removeClass('sticky');   
	}  
	};  	  
	stickyNav();    
	$(window).scroll(function() {  
		stickyNav();  
});
{/if}
	}); 
mydate = new Date("{$smarty.now|date_format:"%d %b %Y %H:%M:%S"}");
{literal}

	$(document).ready(function() {	
		dateTimer();
	});
	
	

{/literal}	
	</script>

{if $settings.googleanalytics == 'yes'}
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '{$settings.googleanalyticsid}']);
  _gaq.push(['_trackPageview']);
{literal}
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
{/literal}
</script>
{/if}
</head>

<body>
<div class="fullsite">
    <div class="wrapper">
        <div id="header">
{if $logged == 'yes'}
<div class="flotator">
    <div class="member_toolbar" style="display:none">
    	
        <ul>
        	<li class="mini_logo"><img src="./templates/ModernBlue/css/images/mini_logo.png" align="absmiddle" /></li>
            <li title="Username"><a href="./?view=account"><img src="images/memberbar/account.png" align="absmiddle" /> {$user_info.username}</a></li>
            <li title="Account balance"><a href="./?view=account"><img src="images/memberbar/coins.png" align="absmiddle" /> ${$user_info.money}</a></li>
            <li title="Purchase balance"><a href="./?view=account&page=addfunds"><img src="images/memberbar/coins_add.png" align="absmiddle" />  ${$user_info.purchase_balance}</a></li>
            <li title="Direct referrals"><a href="./?view=account&page=referrals"><img src="images/memberbar/refs.png" align="absmiddle" />  {$user_info.referrals}</li>
            {if $settings.rent_referrals == 'yes'}
            <li title="Rented referrals"><a href="./?view=account&page=rented_referrals"><img src="images/memberbar/rentedrefs.png" align="absmiddle" /> {$user_info.rented_referrals}</a>
            </li>
            {/if}
            <li title="Account settings">
                <a href="./?view=account&page=settings"><img src="images/memberbar/settings.png" align="absmiddle" /></a>
            </li>
            <li title="My orders">
                <a href="./?view=account&page=history"><img src="images/memberbar/cart.png" align="absmiddle" /></a>
            </li>
            <li title="Statistics">
                <a href="./?view=account&page=statistics"><img src="images/memberbar/stats.png" align="absmiddle" /></a>
            </li>
            <li title="Private messages">
                <a href="./?view=account&page=messages"><img src="images/memberbar/email.png" align="absmiddle" /></a>
            </li>
            <li title="Logout">
                <a href="./?view=logout"><img src="images/memberbar/lock.png" align="absmiddle" /></a>
            </li>
            <li title="Server Time">
                <img src="images/memberbar/clock.png" align="absmiddle" /> <span id="timenow"></span>
            </li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
{/if}
            <div id="logo">
                <a href="./"></a>
            </div>
            <div class="top-banner">{if showrotatingbanners()}{/if}</div>
            <div class="clear"></div>
            <div class="navbar">
                <ul>
                    <li><a href="./" {if $smarty.server.SCRIPT_NAME=='/index.php' && $smarty.get.view == '' || $smarty.get.view == 'home'}class="current"{/if}><span class="white-icon ui-icon-home"></span>{$lang.txt.home}</a></li>
                        <li><a href="index.php?view=advertise" {if $smarty.get.view=='advertise'}class="current"{/if}><span class="white-icon ui-icon-cart"></span>{$lang.txt.advertise}</a></li>
                        
                        <li class="submenu"><a href="javascript:void();" {if $smarty.get.view=='ads'}class="current"{/if}><span class="white-icon ui-icon-star"></span>{$lang.txt.earn_money}</a>
                        	<ul>
                            	<li><a href="index.php?view=ads">{$lang.txt.viewads}</a></li>
                                {if $logged == 'yes' && $settings.ptsu_available == 'yes'}
                                <li><a href="index.php?view=account&page=ptsu">{$lang.txt.ptsu}</a></li>
                                {/if}
                            </ul>
                        </li>
                        {if $logged != 'yes'}
                        <li><a href="index.php?view=login" {if $smarty.get.view=='login'}class="current"{/if}><span class="white-icon ui-icon-person"></span>{$lang.txt.login}</a></li>
                        <li><a href="index.php?view=register" {if $smarty.get.view=='register'}class="current"{/if}><span class="white-icon ui-icon-star"></span>{$lang.txt.register}</a></li>
                        {else}
                        <li><a href="index.php?view=account" {if $smarty.get.view=='account'}class="current"{/if}><span class="white-icon ui-icon-person"></span>{$lang.txt.myaccount}</a></li>
                        {/if}
                        <li><a href="index.php?view=faq" {if $smarty.get.view=='faq'}class="current"{/if}><span class="white-icon ui-icon-note"></span>{$lang.txt.faq}</a></li>
                        {if ($logged == 'yes' && $memberonly_support == 'yes') || ($memberonly_support != 'yes')}
                        <li><a href="index.php?view=contact" {if $smarty.get.view=='contact'}class="current"{/if}><span class="white-icon ui-icon-flag"></span>{$lang.txt.support}</a></li>
                        {/if}
                        {if $logged != 'yes'}
                        <li><a href="index.php?view=terms" {if $smarty.get.view=='terms'}class="current"{/if}><span class="white-icon ui-icon-document"></span>{$lang.txt.terms}</a></li>
                        {/if}
                        {if $settings.forum_active == 'yes'}
                        <li><a href="forum.php" {if $smarty.server.SCRIPT_NAME=='/forum.php'}class="current"{/if}><span class="white-icon ui-icon-comment"></span>{$lang.txt.forum}</a></li>
                        {/if}
                        {if $logged == 'yes'}
                        <li><a href="index.php?view=logout">{$lang.txt.logout}</a></li>
                        {/if}
                </ul>
            <div class="clear"></div>

            </div>
        </div>
     
        <div id="content">
{if $smarty.server.SCRIPT_NAME=='/forum.php'}
<div class="site_title">{$settings.site_name} {$lang.txt.forum}</div>
<div class="site_content">
{/if}