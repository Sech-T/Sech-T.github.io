<?php
/**
 *
 * @ EvolutionScript FULL DECODED & NULLED
 *
 * @ Version  : 5.1
 * @ Author   : MTIMER
 * @ Release on : 2014-09-01
 * @ Website  : http://www.mtimer.net
 *
 **/

if (!defined("EvolutionScript")) {
	exit("Hacking attempt...");
}

echo "<div class=\"widget-title\">System Information</div>
<div class=\"widget-content\">
<table width=\"100%\" class=\"widget-tbl\">
<tr>
<td width=\"200\"><strong>Registered To</strong></td>
<td>";
echo $chkadmin->info['clientname'];
echo " (";
echo $chkadmin->info['clientemail'];
echo ")</td>
</tr>
<tr>
<td><strong>License Type</strong></td>
<td>";
echo $chkadmin->info['product'];
echo "</td>
</tr>
<tr>
<td><strong>License Key</strong></td>
<td>";
echo $ptcevolution->config['Misc']['license'];
echo "</td>
</tr>
<tr>
<td><strong>Valid Domain</strong></td>
<td>";
echo $chkadmin->info['domain'];
echo "</td>
</tr>
<tr>
<td><strong>License Expires</strong></td>
<td>";

if ($chkadmin->info['expires'] == 0) {
	echo "Never";
}
else {
	echo date("d-m-Y", $chkadmin->info['expires']);
}

echo "</td>
</tr>
<tr>
<td><strong>Support Expires</strong></td>
<td>";

if ($chkadmin->info['support'] == 0) {
	echo "Never";
}
else {
	echo date("d-m-Y", $chkadmin->info['support']);
}

echo "</td>
</tr>

</table>
</div>
<div class=\"widget-title\">EvolutionScript Developers &amp; Contributors</div>
<div class=\"widget-content\">
<table width=\"100%\"  class=\"widget-tbl\">
<tr>
<td width=\"200\"><strong>Software Developed By</strong></td>
<td>EvolutionScript.com</td>
</tr>
<tr>
<td><strong>Business Development</strong></td>
<td>Mathias L., Andres Mendoza</td>
</tr>
<tr>
<td><strong>Support Manager</strong></td>
<td>Mathias L., Josue Ramos</td>
</tr>
</table>
    </div>";
?>