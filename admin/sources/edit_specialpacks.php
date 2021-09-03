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

$special = $db->fetchRow("SELECT * FROM specialpacks WHERE id=" . $input->gc['edit']);

if ($input->p['action']) {
	if ($settings['demo'] == "yes") {
		$error_msg = "This is not possible in demo version";
	}
	else {
		if (is_array($input->p['mid'])) {
			foreach ($input->p['mid'] as $mid) {
				switch ($input->p['a']) {
					case "delete":
						$db->delete("specialpacks_list", "id=" . $mid);
				}
			}
		}
	}
}


if ($input->p['do'] == "update_pack") {
	verifyajax();
	verifydemo();
	$set = array("name" => $input->pc['name'], "price" => $input->pc['price'], "enable" => $input->pc['enable']);
	$db->update("specialpacks", $set, "id=" . $special['id']);
	serveranswer(1, "Special pack was updated.");
}
else {
	if ($input->p['do'] == "add_benefits") {
		if ($settings['demo'] == "yes") {
			$error_msg = "This is not possible in demo version";
		}
		else {
			if ($input->p['sesion_id'] != $_SESSION['sesion_id']) {
				$error_msg = "Invalid token try again please";
			}
			else {
				if (empty($input->p['type']) || ($input->p['type'] != "membership" && !is_numeric($input->p['amount']))) {
					$error_msg = "Some fields are incorrect.";
				}
				else {
					$type = $input->pc['type'];
					$amount = $input->pc['amount'];

					if ($type == "ptc_credits") {
						$title = "Paid To Click Credits";
					}
					else {
						if ($type == "fads_credits") {
							$title = "Featured Ad Credits";
						}
						else {
							if ($type == "banerads_credits") {
								$title = "Banner Ad Credits";
							}
							else {
								if ($type == "flink_credits") {
									$title = "Featured Link Ad Credits";
								}
								else {
									if ($type == "ptsu_credits") {
										$title = "Paid To Signup Credits";
									}
									else {
										if ($type == "direct_refs") {
											$title = "Direct Referrals";
										}
										else {
											if ($type == "rented_refs") {
												$title = "Rented Referrals";
											}
											else {
												if ($type == "membership") {
													$title = "Membership";
													$amount = $input->pc['membershipid'];
												}
											}
										}
									}
								}
							}
						}
					}

					$set = array("specialpack" => $special['id'], "title" => $title, "type" => $type, "amount" => $amount);
					$db->insert("specialpacks_list", $set);
					$success_msg = "New benefit was added.";
				}
			}
		}
	}
}

$paginator = new Pagination("specialpacks_list", "specialpack=" . $special['id']);
$paginator->setOrders("id", "DESC");
$paginator->setPage($input->gc['page']);
$paginator->allowedfield($allowed);
$paginator->setNewOrders($input->gc['orderby'], $input->gc['sortby']);
$paginator->setLink(("./?view=specialpacks_settings&edit=" . $special['id'] . "&") . $adlink);
$q = $paginator->getQuery();
include SOURCES . "header.php";
echo "<script type=\"text/javascript\">
function showoptions(){
	typeval = $(\"#type\").val();
	if(typeval == 'membership'){
		$(\"#amount\").hide();
		$(\"#membership\").fadeIn();
	}else{
		$(\"#membership\").hide();
		$(\"#amount\").fadeIn();
	}
}
</script>
<div class=\"site_title\">Edit Special Pack</div>
<div class=\"site_content\">
	<div class=\"widget-title\">General</div>
    <div class=\"widget-content\">
        <form method=\"post\" id=\"frm1\" onsubmit=\"return submitform(this.id);\">
        <input type=\"hidden\" name=\"do\" value=\"update_pack\" />
        <table width=\"100%\" class=\"widget-tbl\">
          <tr>
            <td align=\"right\" width=\"300\">Name</td>
            <td><input type=\"text\" name=\"name\" value=\"";
echo $special['name'];
echo "\" /></td>
          </tr>
          <tr>
            <td align=\"right\">Price </td>
            <td><input type=\"text\" name=\"price\" value=\"";
echo $special['price'];
echo "\" /></td>
          </tr>
          <tr>
            <td align=\"right\">Enable</td>
            <td><input type=\"checkbox\" name=\"enable\"  value=\"yes\" ";

if ($special['enable'] == "yes") {
	echo "checked";
}

echo " /></td>
          </tr>
            <tr>
            	<td></td>
                <td>
                    <input type=\"submit\" name=\"save\" value=\"Save\" />
                    <input type=\"button\" name=\"btn\" value=\"Return\" onclick=\"location.href='./?view=specialpacks_settings'\" />
                </td>
            </tr>
        </table>
        </form>

    </div>

    <div class=\"widget-title\">Add Benefits</div>
    <div class=\"widget-content\">
		";

if ($error_msg) {
	echo "        <div class=\"error_box\">";
	echo $error_msg;
	echo "</div>
        ";
}

echo "		";

if ($success_msg) {
	echo "        <div class=\"success_box\">";
	echo $success_msg;
	echo "</div>
        ";
}

echo "		<form method=\"post\" id=\"frm2\">
		<input type=\"hidden\" name=\"do\" value=\"add_benefits\" />
        <input type=\"hidden\" name=\"sesion_id\" value=\"";
echo sesion_id();
echo "\" />
       <table class=\"widget-tbl\" width=\"100%\">
        	<tr>

                <td width=\"200\">
					Type:
                	<select name=\"type\" onchange=\"showoptions();\" id=\"type\">
                    	<option value=\"ptc_credits\">Paid To Click Credits</option>
	                    <option value=\"fads_credits\">Featured Ad Credits</option>
    	                <option value=\"banerads_credits\">Banner Ad Credits</option>
        	            <option value=\"flink_credits\">Featured Link Ad Credits</option>
            	        <option value=\"ptsu_credits\">Paid To Signup Credits</option>
                        <option value=\"direct_refs\">Direct Referrals</option>
                        <option value=\"rented_refs\">Rented Referrals</option>
                        <option value=\"membership\">Membership</option>
                	</select>




                    </td>
        		<td>
                	<span id=\"amount\">
					Amount:
                	<input type=\"text\" name=\"amount\" />
                    </span>
                    <span id=\"membership\" style=\"display:none\">
                    Select a membership:
                    <select name=\"membershipid\">
                    	";
$mquery = $db->query("SELECT id, name FROM membership WHERE id!=1 ORDER BY price ASC");

while ($row = $db->fetch_array($mquery)) {
	echo "<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>";
}

echo "                    </select>
                    </span>
                    <input type=\"submit\" name=\"btn\" value=\"Add New\" />
                </td>
       	  </tr>
        </table>

        </form>

<form method=\"post\" action=\"";
echo $paginator->gotopage();
echo "\">
          <table width=\"100%\" class=\"widget-tbl\">
            <tr class=\"titles\">
                <td width=\"20\"><input type=\"checkbox\" id=\"checkall\"></td>
                <td>";
echo $paginator->linkorder("type", "Type");
echo "</td>
                <td>";
echo $paginator->linkorder("amount", "Amount");
echo "</td>
            </tr>
            ";

while ($r = $db->fetch_array($q)) {
	$tr = ($tr == "tr1" ? "tr2" : "tr1");

	if ($r['type'] == "membership") {
		$amountname = $db->fetchOne("SELECT name FROM membership WHERE id=" . $r['amount']);
	}
	else {
		$amountname = $r['amount'];
	}

	echo "            <tr class=\"";
	echo $tr;
	echo " normal_linetbl\">
                <td align=\"center\"><input type=\"checkbox\" name=\"mid[]\" value=\"";
	echo $r['id'];
	echo "\" class=\"checkall\" /></td>
                <td><span style=\"color:#000099\">";
	echo $r['title'];
	echo "</span>
                </td>
                <td>
                    <span style=\"color:green\">";
	echo $amountname;
	echo "</span>
                </td>
            </tr>
            ";
}


if ($paginator->totalResults() == 0) {
	echo "            <tr>
                <td colspan=\"8\" align=\"center\">Records not found</td>
            </tr>
            ";
}

echo "          </table>
            <div style=\"margin-top:10px\">
            <input type=\"button\" value=\"&larr; Prev Page\" ";
echo ($paginator->totalPages() == 1 || $paginator->getPage() == 1) ? "disabled class=\"btn-disabled\"" : "onclick=\"location.href='" . $paginator->prevpage() . "';\";";
echo " />

            <input type=\"button\" value=\"Next Page &rarr;\" ";
echo ($paginator->totalPages() == 0 || $paginator->totalPages() == $paginator->getPage()) ? "disabled class=\"btn-disabled\"" : "onclick=\"location.href='" . $paginator->nextpage() . "';\";";
echo " />
                ";

if (1 < $paginator->totalPages()) {
	echo "                <div style=\"float:right\">
                Jump to page:
                <select name=\"p\" style=\"min-width:inherit;\" id=\"pagid\" onchange=\"gotopage(this.value)\">
                    ";
	$i = 1;

	while ($i <= $paginator->totalPages()) {
		if ($i == $paginator->getPage()) {
			echo "<option selected value=\"" . $paginator->gotopage($i) . "\">" . $i . "</option>";
		}
		else {
			echo "<option value=\"" . $paginator->gotopage($i) . "\">" . $i . "</option>";
		}

		++$i;
	}

	echo "                </select>
                <script type=\"text/javascript\">
                    function gotopage(pageid){
                        location.href=pageid;
                    }
                </script>
                </div>
                <div class=\"clear\"></div>
                ";
}

echo "            </div>

            ";

if (0 < $paginator->totalPages()) {
	echo "            <div class=\"widget-title\" style=\"margin-top:5px\">Action</div>
                <div class=\"widget-content\">
                    <select name=\"a\">
                        <option value=\"\">Select one</option>
                        <option value=\"delete\">Delete</option>
                    </select>
                    <input type=\"submit\" name=\"action\" value=\"Submit\" />
                </div>
            ";
}

echo "        </form>
    </div>

</div>


        ";
include SOURCES . "footer.php";
echo " ";
?>