{if $smarty.server.SCRIPT_NAME=='/forum.php'}</div>{/if}

        <div class="processorlist">
        {if in_array(2, $gatewaylist)}<img src="./templates/ModernBlue/css/images/pp.gif" />{/if}
        {if in_array(1, $gatewaylist)}<img src="./templates/ModernBlue/css/images/pz.gif" />{/if}
        {if in_array(6, $gatewaylist)}<img src="./templates/ModernBlue/css/images/stp.gif" />{/if}
        {if in_array(5, $gatewaylist)}<img src="./templates/ModernBlue/css/images/ep.gif" />{/if}
        {if in_array(4, $gatewaylist)}<img src="./templates/ModernBlue/css/images/pm.gif" />{/if}
        {if in_array(7, $gatewaylist)}<img src="./templates/ModernBlue/css/images/py.gif" />{/if}
        {if in_array(8, $gatewaylist)}<img src="./templates/ModernBlue/css/images/bc.gif" />{/if}
        </div>
	</div>
	<div id="footer">
    	<div class="copyright">Copyright &copy; 2014 {$settings.site_name}. All rights reserved.{$copyright}</div>
        <div class="links">
        <a href="index.php">{$lang.txt.home}</a> &nbsp; &bull; &nbsp; 
        <a href="index.php?view=faq">{$lang.txt.faq}</a> &nbsp; &bull; &nbsp; 
        <a href="index.php?view=contact">{$lang.txt.support}</a>
         &nbsp; &bull; &nbsp;  <a href="index.php?view=terms">{$lang.txt.terms}</a>
        {if $settings.payment_proof == 'yes'}
         &nbsp; &bull; &nbsp;  <a href="index.php?view=payment_proof">{$lang.txt.paymentproof}</a>
        {/if}
         &nbsp; &bull; &nbsp;  <a href="index.php?view=news">{$lang.txt.news}</a>
       
        {if $forum_active == 'yes'}
         &nbsp; &bull; &nbsp;  <a href="forum.php">{$lang.txt.forum}</a>
        {/if}
        </div>
        <div class="clear"></div>
	</div>
</div>
</div>


</body>
</html>    
    
