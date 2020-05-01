<?php
require_once "api/Config.php";
require_once "mwt_config.php";
$custom_links = array();
$page_title = "Setup";
include_once "magicWebTemplate/src/inc/layout_header.php";
$cfg = Config::get();
if ($cfg["done_setup"]) {
	header("Location: index.php");
	die();
}
if (isset($_POST["dbhost"])) {
	$cfg["done_setup"] = true;
	$cfg["dbhost"] = $_POST["dbhost"];
	$cfg["dbuser"] = $_POST["dbuser"];
	$cfg["dbpasswd"] = $_POST["dbpasswd"];
	$cfg["db"] = $_POST["db"];
	$cfg["secret"] = bin2hex(random_bytes(32));
	Config::save($cfg);
	echo "Setup successful!";
} else {
	$input_dbhost = new Input("setup_dbhost", "text", "dbhost", "localhost");
	$input_dbuser = new Input("setup_dbuser", "text", "dbuser", "", "", true);
	$input_dbpasswd = new Input("setup_dbpasswd", "password", "dbpasswd");
	$input_db = new Input("setup_db", "text", "db", "magicea");
	$button = new Button("setup_button", "setup");
	$form = new Form("setup.php", "post", array($input_dbhost, $input_dbuser, $input_dbpasswd, $input_db), $button);
	echo $form->getHtml();
}

include_once "magicWebTemplate/src/inc/layout_footer.php";
