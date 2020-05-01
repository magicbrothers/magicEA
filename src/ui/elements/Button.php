<?php
class Button
{
    private $instance;

    private $label;
    private $name;

    public function __construct(string $label, string $name = "")
    {
        $this->instance = MagicUI::getInstance();
        $this->label = $label;
        $this->name = $name;
    }

    public function getHtml(): string
    {
        return "<button".($this->name != "" ? " ".$this->name : "").">".$this->instance->getText($this->label)."</button>";
    }
}
