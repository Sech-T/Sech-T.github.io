{include file="header.tpl"}
    <link rel="stylesheet" href="./js/nivoslider/themes/default/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="./js/nivoslider/themes/light/light.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="./js/nivoslider/themes/bar/bar.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="./js/nivoslider/nivo-slider.css" type="text/css" media="screen" />
    <script type="text/javascript" src="./js/nivoslider/jquery.nivo.slider.js"></script>
<div class="site_content">
    <div class="slider-wrapper theme-light">
        <div id="slider" class="nivoSlider">
            <img src="./templates/ModernBlue/css/images/slider1.jpg" data-thumb="./templates/ModernBlue/css/images/slider1.jpg" alt="" />
            <img src="./templates/ModernBlue/css/images/slider2.jpg" data-thumb="./templates/ModernBlue/css/images/slider2.jpg" alt="" />
        </div>
        <div id="htmlcaption" class="nivo-html-caption">
            <strong>This</strong> is an example of a <em>HTML</em> caption with <a href="#">a link</a>. 
        </div>
    </div>
    <script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider();
    });
    </script>
    
{if $settings.site_stats == 'yes'}
<div class="statistics">
	{$lang.txt.stats3}: <strong>${$statistics.cashout}</strong> &nbsp;&nbsp;&nbsp;
    {$lang.txt.stats1}: <strong>{$statistics.members}</strong> &nbsp;&nbsp;&nbsp;
    {$lang.txt.stats2}: <strong>{$statistics.members_today}</strong>
	{if $settings.usersonline}&nbsp;&nbsp;&nbsp; {$lang.txt.stats4}: <strong>{$statistics.usersonline}</strong>{/if}
</div>
{/if}
    
    
<div class="home-box" style="float:left;">
    <div class="title">Members</div>
        <img src="./templates/ModernBlue/css/images/members.png" align="left" />
        EvolutionScript is designed from scratch. Our innovative features for members give them flexibility and more earning potencial.
        We are always ready to take any advice into consideration.<br /><br /><br />
        <div style="padding-left:30px;">
            <strong>&raquo; What Includes:</strong><br />
            <ul>
                <li>Earn up to $0.01 per click</li>
                <li>Earn up to $0.01 per referral click</li>
                <li>Instant Payments and Receiving System</li>
                <li>Detailed statistics of your referral clicks</li>
                <li>Profesional Support</li>
            </ul>
        </div>

</div>


<div class="home-box" style="float:right;">
    <div class="title">Advertisers</div>
    <img src="./templates/ModernBlue/css/images/advertisers.png" align="left" />
    If you are looking to promote your product or services. This is the right place for you, with competitive prices and 
    the ability to reach thousands of potencial customers, you will get the traffic you always wanted!<br /><br />
   <div style="padding-left:30px;">
        <strong>&raquo; What Includes:</strong><br />
        <ul>
            <li>Add your rotation plan instantly</li>
            <li>Choise of multiple advertisement packs</li>
            <li>Detailed statistics on GeoMap</li>
            <li>Anti-cheat protection</li>
            <li>New type of advertisements</li>
        </ul>
    </div>  
</div>

<div class="clear"></div>

<div style="background:url(/templates/ModernBlue/css/images/briefcase.png) no-repeat scroll 50% 0px;">
{if $settings.fads_available == 'yes'}
	<div class="featured_ads" style="float:left;">
        <div class="title">{$lang.txt.featuredad}</div>
        <div class="fcontent">
            <ul class="featured-ads">
                {if getfeaturedad()}{/if}
            </ul>               
        </div>
	</div>
{/if}
{if $settings.flinks_available == 'yes'}
	<div class="featured_ads">
        <div class="title2">{$lang.txt.featuredlink}</div>
        <div class="fcontent">
            <ul class="featured-ads">
                {if getfeaturedlink()}{/if}
            </ul>               
        </div>
	</div>
{/if}
<div class="clear"></div>
</div>




<div class="clear"></div>

</div>
<!-- End Content -->
{include file="footer.tpl"}