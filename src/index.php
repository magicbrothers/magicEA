<?php
require_once "mwt_config.php";
$loggedin = $ui->isLoggedin();
$custom_links = array();
if ($loggedin) $custom_links = array($ui->getText("logout") => "?logout");
$page_title = $ui->getText("index_title");
require_once "magicWebTemplate/src/inc/layout_header.php";

if ($loggedin) {
	echo "<p>".$ui->getText("index_loggedin", array("player" => $ui->getMagicEA()->getUuidConverter()->getName($ui->getUuid())))."</p>";
} else {
	echo "<p>".$ui->getText("index_welcome")."</p>";
	$input_uuid = new Input("input_uuid", "text", "uuid", "", "", true);
	$input_code = new Input("input_code", "text", "code");
	$button = new Button("login_button", "login");
	$form = new Form("index.php", "post", array($input_uuid, $input_code), $button);
	echo $form->getHtml();
}

require_once "magicWebTemplate/src/inc/layout_footer.php";
