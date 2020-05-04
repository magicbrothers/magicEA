<?php
session_start();

require_once __DIR__."/../api/MagicEA.php";
require_once __DIR__."/elements/Form.php";
require_once __DIR__."/elements/Input.php";
require_once __DIR__."/elements/Button.php";

class MagicUI
{

    private static $instance;

    private $language;
    private $strings;
    private $magicea;

    public function __construct(string $language = "en")
    {
        self::$instance = $this;
        $this->language = $language;
	$this->strings = include_once __DIR__."/lang/".$this->language.".php";
	$this->magicea = new MagicEA();
    }

    public static function getInstance(): MagicUI
    {
        return self::$instance;
    }

    public function getMagicEa(): MagicEA
    {
	    return $this->magicea;
    }

    public function getText(string $identifier, array $replacements = array()): string
    {
	    $text = $this->strings[$identifier];
	    foreach ($replacements as $search => $replace) {
		    $text = str_replace("%".$search."%", $replace, $text);
	    }
	    return $text;
    }

    public function isLoggedin(): bool
    {
	    $data = "";
	    $secret = "";
	    if (isset($_SESSION["magicea_token"])) {
		    $exploded = explode(":", $_SESSION["magicea_token"]);
		    $data = $exploded[0];
		    $secret = $exploded[1];
	    }
	    elseif (isset($_POST["uuid"]) && isset($_POST["code"])) {
		    $data = "player;".$this->getMagicEa()->getUuidConverter()->getUuid($_POST["uuid"]).";-1";
		    $secret = $_POST["code"];
	    }

	    $loggedin = $this->getMagicEa()->createSecret($data) == $secret;
	    if ($loggedin && !isset($_SESSION["magicea_token"])) $_SESSION["magicea_token"] = $data.":".$secret;
	    return $loggedin;
    }

    public function getRole(): string
    {
	    if (!$this->isLoggedin()) return "";
	    return explode(";", $_SESSION["magicea_token"])[0];
    }

    public function getUuid(): string
    {
	    if (!$this->isLoggedin()) return "";
	    return explode(";", $_SESSION["magicea_token"])[1];
    }
}

if (isset($_GET["logout"])) session_destroy();
