<?php
class Input
{
    private $instance;

    private $label;
    private $type;
    private $name;
    private $value;
    private $placeholder;
    private $autofocus;

    public function __construct(string $label, string $type, string $name, string $value = "", string $placeholder = "", bool $autofocus = false)
    {
        $this->instance = MagicUI::getInstance();
        $this->label = $label;
        $this->type = $type;
        $this->name = $name;
        $this->value = $value;
	$this->placeholder = $placeholder;
	$this->autofocus = $autofocus;
    }

    public function getHtml(): string
    {
        return "<label>".$this->instance->getText($this->label).": <input type='".$this->type."' name='".$this->name."' value='".$this->value."' placeholder='".$this->placeholder."'".($this->autofocus ? " autofocus" : "")." />";
    }

}
