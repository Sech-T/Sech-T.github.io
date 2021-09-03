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

$adminnavmenu = array("Home" => array("link" => "./", "class" => (((($input->g['view'] == "" || $input->g['view'] == "loginlog") || $input->g['view'] == "account") || $input->g['view'] == "administrators") ? "current" : ""), "menu" => array("Dashboard" => "./", "Login Log" => "?view=loginlog", "My Account" => "?view=account", "Manage Administrators" => "?view=administrators", "Logout" => "?view=logout")), "Members" => array("link" => "?view=members", "class" => (((($input->g['view'] == "members" || $input->g['view'] == "addmember") || $input->g['view'] == "massmail") || $input->g['view'] == "massmessage") ? "current" : ""), "menu" => array("Manage Members" => "?view=members", "Add a New Member" => "?view=addmember", "Sendmail" => "?view=massmail", "On-Site Messages" => "?view=massmessage")), "Advertisements" => array("link" => "?view=manageptc", "class" => ((((((((((((($input->g['view'] == "manageptc" || $input->g['view'] == "ptcads_settings") || $input->g['view'] == "fads_settings") || $input->g['view'] == "managefad") || $input->g['view'] == "flinks_settings") || $input->g['view'] == "manageflink") || $input->g['view'] == "bannerads_settings") || $input->g['view'] == "ptsu_settings") || $input->g['view'] == "manageptsu") || $input->g['view'] == "ptsu_pending") || $input->g['view'] == "specialpacks_settings") || $input->g['view'] == "loginads_settings") || $input->g['view'] == "manageloginad") ? "current" : ""), "menu" => array("Paid To Clicks" => array("PTC Ads Settings" => "?view=ptcads_settings", "Manage PTC Ads" => "./?view=manageptc", "Create a New PTC Ad" => "./?view=manageptc&new_ptc=addnew"), "Featured Ads" => array("Featured Ads Settings" => "./?view=fads_settings", "Manage Featured Ads" => "./?view=managefad", "Create a New Featured Ad" => "./?view=managefad&new_fad=addnew"), "Featured Link Ads" => array("Featured Link Ads Settings" => "./?view=flinks_settings", "Manage Featured Link Ads" => "./?view=manageflink", "Create a New Featured Link Ad" => "./?view=manageflink&new_flink=addnew"), "Banner Ads" => array("Banner Ads Settings" => "?view=bannerads_settings", "Manage Banner Ads" => "?view=managebannerad", "Create a New Banner Ad" => "./?view=managebannerad&new_bannerad=addnew"), "Login Ads" => array("Login Ads Settings" => "?view=loginads_settings", "Manage Login Ads" => "?view=manageloginad", "Create a New Login Ad" => "?view=manageloginad&new_loginads=addnew"), "PTSU Offers" => array("PTSU Settings" => "./?view=ptsu_settings", "Manage PTSU Offers" => "./?view=manageptsu", "PTSU Waiting For Review" => "./?view=ptsu_pending", "Create a New PTSU Offer" => "./?view=manageptsu&new_ptsu=addnew"), "Special Packages" => "?view=specialpacks_settings")), "Orders" => array("link" => "?view=orders", "class" => ($input->g['view'] == "orders" ? "current" : ""), "menu" => array("All Orders" => "?view=orders", "Pending Orders" => "?view=orders&do=search&status=Pending", "Completed Orders" => "?view=orders&do=search&status=Completed")), "Deposits" => array("link" => "?view=deposits", "class" => (($input->g['view'] == "deposits" || $input->g['view'] == "add_deposit") ? "current" : ""), "menu" => array("View deposits" => "?view=deposits", "Add Manual Deposit" => "?view=add_deposit")), "Withdrawals" => array("link" => "?view=withdrawals", "class" => ($input->g['view'] == "withdrawals" ? "current" : ""), "menu" => array("All Withdrawals" => "./?view=withdrawals", "Pending Withdrawal" => "./?view=withdrawals&do=search&status=Pending", "Completed Withdrawal" => "./?view=withdrawals&do=search&status=Completed", "Cancelled Withdrawal" => "./?view=withdrawals&do=search&status=Cancelled")), "Support" => array("link" => "?view=support", "class" => (($input->g['view'] == "support_settings" || $input->g['view'] == "support") ? "current" : ""), "menu" => array("Support Settings" => "./?view=support_settings", "Open Tickets" => "./?view=support&do=search&status=1", "Answered" => "./?view=support&do=search&status=2", "Awaiting reply" => "./?view=support&do=search&status=3", "Closed" => "./?view=support&do=search&status=4")), "Content" => array("link" => "?view=news", "class" => (((($input->g['view'] == "news" || $input->g['view'] == "faq") || $input->g['view'] == "tos") || $input->g['view'] == "sitebanners") ? "current" : ""), "menu" => array("Manage News" => "./?view=news", "Manage FAQ" => "./?view=faq", "Manage Site Banners" => "./?view=sitebanners", "Edit TOS" => "?view=tos", "Email Templates" => "?view=email_template")), "Utilities" => array("link" => "?view=blacklist", "class" => (((((((((((($input->g['view'] == "addon_modules" || $input->g['view'] == "admin_advertisement") || $input->g['view'] == "blacklist") || $input->g['view'] == "assignreferral") || $input->g['view'] == "linktracker") || $input->g['view'] == "repair_statistics") || $input->g['view'] == "googleanalytics") || $input->g['view'] == "multipleips") || $input->g['view'] == "install_language") || $input->g['view'] == "install_template") || $input->g['view'] == "cheat_logs") || $input->g['view'] == "topdomains") ? "current" : ""), "menu" => array("Addon Modules" => "./?view=addon_modules", "Admin Advertisement" => "./?view=admin_advertisement", "Blacklist" => "./?view=blacklist", "Assign Referrals" => "?view=assignreferral", "Campaign Tracker" => "?view=linktracker", "Repair Statistics" => "./?view=repair_statistics", "Clean site cache" => "./?view=clean_cache", "Google Analytics" => "?view=googleanalytics", "Multiple IP Settings" => "?view=multipleips", "Top Domains" => "?view=topdomains", "Cheat Logs" => "?view=cheat_logs", "Install / Create a new Language" => "./?view=install_language", "Install Template" => "./?view=install_template")), "Setup" => array("link" => "?view=general", "class" => ((((((((((($input->g['view'] == "general" || $input->g['view'] == "captcha") || $input->g['view'] == "automation") || $input->g['view'] == "gateways") || $input->g['view'] == "membership") || $input->g['view'] == "buy_referrals") || $input->g['view'] == "rent_referrals") || $input->g['view'] == "forum_settings") || $input->g['view'] == "language_settings") || $input->g['view'] == "template_settings") || $input->g['view'] == "signupbonus") ? "current" : ""), "menu" => array("General Settings" => "?view=general", "Signup Bonus" => "?view=signupbonus", "Captcha Settings" => "?view=captcha", "Automation Settings" => "?view=automation", "Payment Gateways" => "?view=gateways", "Membership Settings" => "?view=membership", "Buy Referrals Settings" => "?view=buy_referrals", "Rent Referrals Settings" => "?view=rent_referrals", "Forum Integration" => "?view=forum_settings", "Language Settings" => "?view=language_settings", "Template Settings" => "?view=template_settings")));

if (!$admin->permissions['manage_members']) {
	unset($adminnavmenu['Members']['menu']['Manage Members']);
}


if (!$admin->permissions['add_new_member']) {
	unset($adminnavmenu['Members']['menu']['Add a New Member']);
}


if (!$admin->permissions['send_mail']) {
	unset($adminnavmenu['Members']['menu']['Sendmail']);
}


if (!$admin->permissions['send_messages']) {
	unset($adminnavmenu['Members']['menu']['On-Site Messages']);
}


if (empty($adminnavmenu['Members']['menu'])) {
	unset($adminnavmenu['Members']);
}


if (!$admin->permissions['ptcads']) {
	unset($adminnavmenu['Advertisements']['menu']["Paid To Clicks"]['Create a New PTC Ad']);
}


if (!$admin->permissions['ptcads_manager']) {
	unset($adminnavmenu['Advertisements']['menu']["Paid To Clicks"]['PTC Ads Settings']);
	unset($adminnavmenu['Advertisements']['menu']["Paid To Clicks"]['Manage PTC Ads']);
}


if (empty($adminnavmenu['Advertisements']['menu']["Paid To Clicks"])) {
	unset($adminnavmenu['Advertisements']['menu']['Paid To Clicks']);
}


if (!$admin->permissions['featuredads']) {
	unset($adminnavmenu['Advertisements']['menu']["Featured Ads"]['Create a New Featured Ad']);
}


if (!$admin->permissions['featuredads_manager']) {
	unset($adminnavmenu['Advertisements']['menu']["Featured Ads"]['Featured Ads Settings']);
	unset($adminnavmenu['Advertisements']['menu']["Featured Ads"]['Manage Featured Ads']);
}


if (empty($adminnavmenu['Advertisements']['menu']["Featured Ads"])) {
	unset($adminnavmenu['Advertisements']['menu']['Featured Ads']);
}


if (!$admin->permissions['featuredlinks']) {
	unset($adminnavmenu['Advertisements']['menu']["Featured Link Ads"]['Create a New Featured Link Ad']);
}


if (!$admin->permissions['featuredlinks_manager']) {
	unset($adminnavmenu['Advertisements']['menu']["Featured Link Ads"]['Featured Ads Settings']);
	unset($adminnavmenu['Advertisements']['menu']["Featured Link Ads"]['Manage Featured Ads']);
}


if (empty($adminnavmenu['Advertisements']['menu']["Featured Link Ads"])) {
	unset($adminnavmenu['Advertisements']['menu']['Featured Link Ads']);
}


if (!$admin->permissions['bannerads']) {
	unset($adminnavmenu['Advertisements']['menu']["Banner Ads"]['Create a New Banner Ad']);
}


if (!$admin->permissions['bannerads_manager']) {
	unset($adminnavmenu['Advertisements']['menu']["Banner Ads"]['Banner Ads Settings']);
	unset($adminnavmenu['Advertisements']['menu']["Banner Ads"]['Manage Banner Ads']);
}


if (empty($adminnavmenu['Advertisements']['menu']["Banner Ads"])) {
	unset($adminnavmenu['Advertisements']['menu']['Banner Ads']);
}


if (!$admin->permissions['loginads']) {
	unset($adminnavmenu['Advertisements']['menu']["Login Ads"]['Create a New Login Ad']);
}


if (!$admin->permissions['loginads_manager']) {
	unset($adminnavmenu['Advertisements']['menu']["Login Ads"]['Login Ads Settings']);
	unset($adminnavmenu['Advertisements']['menu']["Login Ads"]['Manage Login Ads']);
}


if (empty($adminnavmenu['Advertisements']['menu']["Login Ads"])) {
	unset($adminnavmenu['Advertisements']['menu']['Login Ads']);
}


if (!$admin->permissions['ptsuoffers']) {
	unset($adminnavmenu['Advertisements']['menu']["PTSU Offers"]['Create a New PTSU Offer']);
}


if (!$admin->permissions['ptsuoffers_manager']) {
	unset($adminnavmenu['Advertisements']['menu']["PTSU Offers"]['PTSU Settings']);
	unset($adminnavmenu['Advertisements']['menu']["PTSU Offers"]['Manage PTSU Offers']);
	unset($adminnavmenu['Advertisements']['menu']["PTSU Offers"]['PTSU Waiting For Review']);
}


if (empty($adminnavmenu['Advertisements']['menu']["PTSU Offers"])) {
	unset($adminnavmenu['Advertisements']['menu']['PTSU Offers']);
}


if (!$admin->permissions['specialpacks']) {
	unset($adminnavmenu['Advertisements']['menu']['Special Packages']);
}


if (empty($adminnavmenu['Advertisements']['menu'])) {
	unset($adminnavmenu['Advertisements']);
}


if (!$admin->permissions['orders']) {
	unset($adminnavmenu['Orders']);
}


if (!$admin->permissions['deposits']) {
	unset($adminnavmenu['Deposits']);
}


if (!$admin->permissions['withdrawals']) {
	unset($adminnavmenu['Withdrawals']);
}


if (!$admin->permissions['support']) {
	unset($adminnavmenu['Support']['menu']['Support Settings']);
}


if (!$admin->permissions['support_manager']) {
	unset($adminnavmenu['Support']['menu']['Open Tickets']);
	unset($adminnavmenu['Support']['menu']['Answered']);
	unset($adminnavmenu['Support']['menu']['Awaiting reply']);
	unset($adminnavmenu['Support']['menu']['Closed']);
}


if (empty($adminnavmenu['Support']['menu'])) {
	unset($adminnavmenu['Support']);
}


if (!$admin->permissions['site_content']) {
	unset($adminnavmenu['Content']);
}


if (!$admin->permissions['utilities']) {
	unset($adminnavmenu['Utilities']);
}


if (!$admin->permissions['setup']) {
	unset($adminnavmenu['Setup']);
}


if (!$admin->permissions['administrators']) {
	unset($adminnavmenu['Home']['menu']['Manage Administrators']);
}

$test = array("setup" => "Able to manage Setup tab content", "administrators" => "Able to manage administrators");
?>