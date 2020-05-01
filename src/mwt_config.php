<?php
$cc_by = "magicbrothers";
$cc_by_url = "https://github.com/magicbrothers";
$base = "https://".$_SERVER["HTTP_HOST"]."/";
$header = "magicEA";
$links = array("Home" => "index.php");
// needed in every magicEA UI file:
require_once __DIR__."/ui/MagicUI.php";
$ui = new MagicUI();