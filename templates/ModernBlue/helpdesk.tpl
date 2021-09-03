{include file="header.tpl"}
<!-- Content -->
<div class="site_title">{$settings.site_name} {$lang.txt.support}</div>
<div class="site_content">
{if $helpdesk_enable != 'yes'}
{$lang.txt.supportcenterdisabled}
{else}

{if $smarty.get.t == 'new'}
<form method="post" onsubmit="return submitform(this.id);" id="helpdeskform">
<input type="hidden" name="action" value="open" />
<input type="hidden" name="token" value="{getToken('new_ticket')}" />
<table width="100%" class="widget-tbl">
	{if $logged != 'yes'}
	<tr>
    	<td align="right">{$lang.txt.fullname}:</td>
        <td><input type="text" name="name" id="hdname" /></td>
	</tr>
	<tr>
    	<td align="right">{$lang.txt.email}:</td>
        <td><input type="text" name="email" id="hdemail" /></td>
	</tr>
    {/if}
    <tr>
    	<td width="150" align="right">{$lang.txt.department}:</td>
        <td>
			<select name="department" id="departmentshd">
{section name=d loop=$daparment}
	<option value="{$daparment[d].id}" class="whoo">{$daparment[d].name}</option>
{/section} 
			</select>
        </td>
    </tr>
	<tr>
    	<td align="right">{$lang.txt.subject}:</td>
        <td><input type="text" name="subject" id="hdsubject" />		</td>
	</tr>
    <tr>
    	<td colspan="2" align="center">
        <textarea name="message" id="hdmessage" style="width:95%; height:200px"></textarea>
        </td>
    </tr>
    {if $settings.captcha_contact=='yes' && $settings.captcha_type != 0}
    <tr>
    	<td align="right" valign="top">{$lang.txt.imgverification}:</td>
        <td>{$captcha}</td>
    </tr>
    {/if}
    <tr>
    	<td></td>
        <td><input type="submit" name="send" value="{$lang.txt.send}"> <input type="button" name="btn" value="{$lang.txt.go_back}" onclick="history.back();" /></td>
    </tr>
</table>
</form>
          
{else}


{if $logged != 'yes'}

<p>{$lang.txt.support_description} </p>

<form method="post" id="checkticketsfrm" onsubmit="return submitform(this.id);">
<input type="hidden" name="do" value="checkticket" />
<input type="hidden" name="token" value="{getToken('check_ticket')}" />
<table>
	<tr>
    	<td width="50%" valign="top">
        	<div class="widget-title">{$lang.txt.opennewticket}</div>
            <div class="widget-content" style="height:130px">
                <div class="open-ticket-box">
                    <div>{$lang.txt.opennewticketdescr}</div>
                    <div><input type="button" onclick="location.href='./?view=contact&t=new';" value="{$lang.txt.opennewticket}" />
                </div>
            </div>
        </td>
        <td valign="top">
        	<div class="widget-title">{$lang.txt.checkticketstatus}</div>
            <div class="widget-content" style="height:130px">
        	<div class="view-ticket-box">
                <div style="padding-bottom:10px;">{$lang.txt.ticket_status_description}</div>
                <div>
                                <table>
                	<tr>
                    	<td>{$lang.txt.ticketid}:</td>
                        <td><input type="text" name="ticketid" id="ticketid" class="input_txt"></td>
                    </tr>
                    <tr>
                    	<td></td>
                    	<td>
                        	<input type="submit" name="send" value="{$lang.txt.viewticket}">
                        </td>
                    </tr>
                </table>
                </div>
            </div>
            </div>
        </td>
    </tr>
</table>
</form>
{else}
<script type="text/javascript">
$(function(){
	$("#tablelist tr:even").addClass("tr1");
	$("#tablelist tr:odd").addClass("tr2");
});
</script>
<div class="widget-content">
	<table width="100%" class="tbl-content">
    	<tr>
        	<td width="20"><span class="system-icon application_form_add"></span></td>
            <td width="200"><a href="./?view=contact&t=new"><strong>{$lang.txt.create_new_ticket} &raquo;</strong></a></td>
            <td>{$lang.txt.create_ticket_descr}</td>
        </tr>
        <tr>
        	<td><span class="system-icon flag_orange"></span></td>
            <td><a href="./?view=contact&sort=2">{$lang.txt.view_active_support_tickets}</a></td>
            <td>{$lang.txt.tickets_with_new_replies_msg}</td>
        </tr>
        <tr>
        	<td><span class="system-icon flag_green"></span></td>
            <td><a href="./?view=contact&sort=1">{$lang.txt.view_open_tickets}</a></td>
            <td>{$lang.txt.view_open_tickets_msg}</td>
        </tr>
        <tr>
        	<td><span class="system-icon flag_red"></span></td>
            <td><a href="./?view=contact&sort=3">{$lang.txt.view_closed_tickets}</a></td>
            <td>{$lang.txt.view_closed_tickets_msg}</td>
        </tr>
    </table>
</div>
<div class="widget-title">{$lang.txt.my_tickets}</div>
<table width="100%" class="widget-tbl">
	<tr class="titles">
        <td>{$lang.txt.ticketid}</td>
        <td>{$lang.txt.subject}</td>
        <td>{$lang.txt.last_update}</td>
        <td>{$lang.txt.status}</td>
    </tr>
    <tbody id="tablelist">
        {foreach item=item from=$thelist}
            <tr>
                <td align="center"><a href="./?view=contact&view_ticket={$item.ticket}">{$item.ticket}</a></td>
                <td>{$item.subject}</td>
                <td>{$item.last_update|date_format:"%b %e, %Y"}</td>
                <td align="center">
                {if $item.status == 1}
                	<span style="color:green">{$lang.txt.open}</span>
               {elseif $item.status == 2}
                	<span style="color:#000000">{$lang.txt.answered}</span>
               {elseif $item.status == 3}
                	<span style="color:#ff6600">{$lang.txt.awaiting_reply}</span>
               {elseif $item.status == 4}
                	<span style="color:#888888">{$lang.txt.closed}</span>
               	{/if}
                </td>
            </tr>
        {/foreach}    
    </tbody>
        {if $paginator->totalResults() == 0}
        <tr>
            <td colspan="10" align="center">{$lang.txt.tickets_not_found}</td>
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
{/if}

{/if}

{/if}

</div>
<!-- End Content -->
{include file="footer.tpl"}