<!-- Content -->
<div class="widget-main-title">{$lang.txt.deposithistory}</div>
<div class="widget-content">
<table width="100%" class="widget-tbl">



<tr class="titles">
        <td align="center">{$paginator->linkorder('date', $lang.txt.date)}</td>
        <td align="center">{$paginator->linkorder('fromacc', $lang.txt.account)}</td>
        <td align="center">{$paginator->linkorder('method', $lang.txt.method)}</td>
        <td align="center">{$paginator->linkorder('amount', $lang.txt.amount)}</td>
    </tr>
    

        {foreach item=item from=$thelist}
            <tr>
                <td align="center">{$item.date|date_format:"%b %e, %Y"}</td>
                <td>{$item.fromacc}</td>
                <td align="center"><img src="images/proofs/{$item.method}.gif" /></td>
                <td align="center">{$item.amount}</td>
            </tr>
        {/foreach}    

        {if $paginator->totalResults() == 0}
        <tr>
            <td colspan="10" align="center">{$lang.txt.no_deposits}</td>
        </tr>
        {/if}
</table>

<div style="margin-top:10px">
    <input type="button" value="&larr; {$lang.txt.prev_page}" {if $paginator->totalPages() == 1 || $paginator->getPage()==1}disabled class="btn-disabled"{else}onclick="location.href='{$paginator->prevpage()}';"{/if} />

    <input type="button" value="{$lang.txt.next_page} &rarr;" {if $paginator->totalPages() == 0 || $paginator->totalPages() == $paginator->getPage()}disabled class="btn-disabled"{else}onclick="location.href='{$paginator->nextpage()}';"{/if} />
    	{if $paginator->totalPages() > 1}
        <div style="float:right">
        {$lang.txt.jump_page}: 
        <select name="p" style="min-width:inherit;" id="pagid" onchange="gotopage(this.value)">
           {for $i=1 to $paginator->totalPages()}
				{if $i == $paginator->getPage()}
                	<option selected value="{$paginator->gotopage($i)}">{$i}</option>
				{else}
					<option value="{$paginator->gotopage($i)}">{$i}</option>
				{/if}
            {/for}
        </select> 
        <script type="text/javascript">
			function gotopage(pageid){
				location.href=pageid;
			}
		</script>
        </div> 
        <div class="clear"></div>
        {/if}
    </div>



</div>