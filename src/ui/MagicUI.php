<?php
require_once __DIR__."/elements/Form.php";
require_once __DIR__."/elements/Input.php";
require_once __DIR__."/elements/Button.php";

class MagicUI
{

    private static $instance;

    private $language;
    private $strings;

    public function __construct(string $language = "en")
    {
        self::$instance = $this;
        $this->language = $language;
        $this->strings = include_once __DIR__."/lang/".$this->language.".php";
    }

    public static function getInstance(): MagicUI
    {
        return self::$instance;
    }

    public function getText(string $identifier): string
    {
        return $this->strings[$identifier];
    }

}